import { map } from './functions';

const urlHelper = {
  replaceUrl(newPath) {
    if (window.history) {
      window.history.replaceState(
        null,
        null,
        newPath + global.location.hash || '',
      );
    }
  },
  getSearch(url) {
    const pat = /[^?]+(\?.*$)/;
    const search = pat.test(url) && pat.exec(url)[1];
    return search;
  },
  getQuery(url = location.href) {
    const search = this.getSearch(url);
    const query = {};
    if (search) {
      const searchParams = [...new URLSearchParams(search)];
      searchParams.forEach(([key, value]) => {
        if (Number.isNaN(value)) {
          value = Number(value);
        } else if (value === 'true') {
          value = true;
        } else if (value === 'false') {
          value = false;
        }
        query[key] = decodeURIComponent(value);
      });
    }
    return query;
  },
  createQueryString(params, currentQuery = {}) {
    const searchParams = new URLSearchParams('');
    Object.assign(currentQuery, params);

    map(currentQuery, (value, key) => {
      searchParams.append(key, value);
    });
    const str = searchParams.toString();
    return str ? `?${str}` : '';
  },
  appendQuery(data) {
    const url = location.href;
    const currentSearch = this.getSearch(url);
    const query = this.getQuery(url);
    const nextSearch = this.createQueryString(data, query);
    let resultUrl;

    if (currentSearch) {
      resultUrl = url.replace(currentSearch, nextSearch);
    } else {
      resultUrl = `${url}${nextSearch}`;
    }
    window.history.pushState(null, null, resultUrl);
    return resultUrl;
  },
  replaceQuery(url, data) {
    const currentSearch = this.getSearch(url);
    const nextSearch = this.createQueryString(data);
    let resultUrl;

    if (currentSearch) {
      resultUrl = url.replace(currentSearch, nextSearch);
    } else {
      resultUrl = `${url}${nextSearch}`;
    }
    return resultUrl;
  },
  removeQuery(url) {
    return this.replaceQuery(url, {});
  },
  getLink(routePath, args, query) {
    const p = /:([^\d][\w]+)(\(.*?\))?/g;
    const matches = routePath.match(p);
    if (matches) {
      matches.forEach((e) => {
        const result = p.exec(e) || /:([\w]+)/g.exec(e);
        const name = result[1];
        const value = args[name];
        const pattern = result[2];

        if (value) {
          if (pattern) {
            const regex = new RegExp(pattern);
            if (!regex.test(value)) {
              console.error(
                `:${name} (${value}) doesn't match Regex: ${pattern}`,
              );
            }
          }
          routePath = routePath.replace(e, value);
        } else {
          const mess = `:${name} required`;
          console.error(mess);
        }
      });
    }

    if (query) {
      routePath = urlHelper.replaceQuery(routePath, query);
    }

    return routePath;
  },
  getPathname(url) {
    const pat = /(^(?:https?:\/\/)?[^/]+)((.*?)$)/i;
    if (pat.test(url)) {
      const [str, host, pathname] = pat.exec(url);
      return pathname;
    }
    return '';
  },
};

export default urlHelper;

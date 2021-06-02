import socket from 'webpack-dev-server/client/socket';
import createSocketUrl from 'webpack-dev-server/client/utils/createSocketUrl';

async function getPageHtml() {
  return fetch(location.href).then(async (resp) => {
    const responseText = await resp.text();
    const pat = /<html[\s\S]+$/gm;
    const match = responseText.match(pat);
    return match && match[0];
  });
}

export async function setupHTMLWatcher(intervalTime) {
  const originalHtml = await getPageHtml();
  const runCheckLatestContentAndReload = async () => {
    // Check and reload page
    const newHtml = await getPageHtml();
    if (newHtml !== originalHtml) {
      window.location.reload();
    }
  };

  // Connect to webpack dev server socket
  // eslint-disable-next-line no-undef
  const socketUrl = createSocketUrl(__resourceQuery);
  socket(socketUrl, {
    invalid: function invalid() {
      clearTimeout(window.__reloadTimeout);
      window.__reloadTimeout = setTimeout(runCheckLatestContentAndReload, 10);
    },
  });
}

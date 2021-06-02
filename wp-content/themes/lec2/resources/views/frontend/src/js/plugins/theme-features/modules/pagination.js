export default function pagination(total, current, url, nearbyPagesLimit = 4) {
  let $html = '';
  if (total > 1) {
    $html += '<div class="pagination">';
    let prevDisable = '';
    if (current === 1) {
      prevDisable = ' disabled';
    }
    $html += `<a class="prev page-number${prevDisable}" data-page="${current - 1}" href="${url}?page=${
      current - 1
    }"><em class="icon-chevron-left-solid"></em></a>`;
    for (let i = 1; i <= total; i++) {
      if ((current - nearbyPagesLimit - i) === 0) {
        $html += `<a class="page-number" data-page="${i}" href="${url}?page=${i}">${i}</a>`;
        if (i !== 1) {
          $html += '<span class="page-number">...</span>';
        }
      } else if ((current + nearbyPagesLimit) - i === 0 && (current + nearbyPagesLimit < total)) {
        $html += '<span class="page-number">...</span>';
      } else if ((current - nearbyPagesLimit) - i > 0) {
        $html += '';
      } else if ((current + nearbyPagesLimit) - i < 0) {
        $html += '';
      } else if (current === i) {
        $html += `<span class="page-number current" aria-current="page">${i}</span>`;
      } else {
        $html += `<a class="page-number" data-page="${i}" href="${url}?page=${i}">${i}</a>`;
      }
    }
    if (current !== total && (current + nearbyPagesLimit) < total) {
      $html += `<a class="page-number" data-page="${total}" href="${url}?page=${total}">${total}</a>`;
    }

    let nextDisable = '';
    if (current >= total) {
      nextDisable = ' disabled';
    }
    $html += `<a class="next page-number${nextDisable}" data-page="${current + 1}" href="${url}?page=${
      current + 1
    }"><em class="icon-chevron-right-solid"></em></a>`;
    $html += '</div>';
  }
  return $html;
}
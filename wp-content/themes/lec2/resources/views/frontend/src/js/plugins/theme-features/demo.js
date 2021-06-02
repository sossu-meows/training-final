function applyDemo() {
  if (!$('body').hasClass('twig-adatper')) {
    return null;
  }
  return true;
}

$(document).ready(applyDemo);

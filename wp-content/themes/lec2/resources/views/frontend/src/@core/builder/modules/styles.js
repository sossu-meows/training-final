// styles
require('@/scss/lib/lib.scss');

function requireAll(r) { r.keys().forEach(r); }

require('@/scss/style.scss');

const scssInViews = require.context('@/views/', true, /[^_]\.scss/);

requireAll(scssInViews);

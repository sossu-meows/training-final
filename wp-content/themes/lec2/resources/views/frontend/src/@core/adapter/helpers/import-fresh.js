module.exports = (moduleId) => {
  // eslint-disable-next-line import/no-dynamic-require
  const module = require(moduleId);
  delete require.cache[moduleId];
  return module;
};

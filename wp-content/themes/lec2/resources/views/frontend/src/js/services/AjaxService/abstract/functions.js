export function convertToMultipartForm(data) {
  const formData = new FormData();
  Object.entries(data).forEach(([key, val]) => {
    if (key && val) {
      if (Array.isArray(val)) {
        val.forEach(e => formData.append(`${key}[]`, e));
      } else {
        formData.append(key, val);
      }
    }
  });
  return formData;
}
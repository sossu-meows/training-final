export default yup => ({
  email: yup
    .string()
    .email()
    .required(),
  password: yup
    .string()
    .min(6)
    .required(),
  repeatedPassword: yup
    .string()
    .sameAs('password', 'Password')
    .required(),
});

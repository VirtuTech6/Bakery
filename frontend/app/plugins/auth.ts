export default defineNuxtPlugin(async (nuxtApp) => {
    const token = localStorage.getItem('token');
    if (token) {
      const config = useRuntimeConfig();
      config.public.token = token;
      useState('token').value = token;
    }
  });
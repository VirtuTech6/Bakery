// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  compatibilityDate: "2025-03-05",
  runtimeConfig: {
    public: {
      apiBase: 'http://localhost:8000'
    }
  },
})
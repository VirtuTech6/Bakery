export default defineNuxtConfig({
    app: {
      middleware: ['admin']
    },
    routeRules: {
      '/admin/**': { middleware: ['admin'] }
    }
  }); 
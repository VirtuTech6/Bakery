interface User {
  role: string;
  [key: string]: any;
}

export default defineNuxtPlugin(async (nuxtApp) => {
  if (process.client) {
    const token = localStorage.getItem('token');
    
    if (token) {
      const config = useRuntimeConfig();
      config.public.token = token;
      useState('token').value = token;

      // Vérifier les rôles de l'utilisateur
      try {
        const { data: userData } = await useFetch<User>('/api/user/me', {
          baseURL: 'http://localhost:8000',
          headers: {
            Authorization: `Bearer ${token}`
          }
        });

        if (userData.value) {
          useState<User>('user').value = userData.value;
        }
      } catch (error) {
        console.error('Erreur lors de la récupération des informations utilisateur:', error);
      }
    }
  } else {
    console.error('localStorage n\'est pas disponible côté serveur');
  }
});
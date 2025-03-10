interface User {
  role: string;
  [key: string]: any;
}

export default defineNuxtRouteMiddleware(async (to) => {
  // Vérification côté client
  if (process.client) {
    const token = localStorage.getItem('token');
    let user = useState<User>('user').value;

    // Si on a un token mais pas d'utilisateur, on récupère les infos
    if (token && !user) {
      try {
        const { data: userData } = await useFetch<User>('/api/user/me', {
          baseURL: 'http://localhost:8000',
          headers: {
            Authorization: `Bearer ${token}`
          }
        });

        if (userData.value) {
          user = userData.value;
          useState<User>('user').value = user;
        }
      } catch (error) {
        console.error('Erreur lors de la récupération des informations utilisateur:', error);
        localStorage.removeItem('token');
        return navigateTo('/admin/log');
      }
    }

    // Si l'utilisateur est connecté et tente d'accéder à la page de connexion
    if (to.path === '/admin/log' && token && user) {
      return navigateTo('/admin/panel');
    }

    // Protection des routes admin
    if (to.path.startsWith('/admin')) {
      if (!token) {
        return navigateTo('/admin/log');
      }

      if (!user || !['ROLE_MANAGER', 'ROLE_ADMIN'].includes(user.role)) {
        return navigateTo('/');
      }
    }
  }
  // Vérification côté serveur
  else {
    const token = useState('token').value;
    const user = useState<User>('user').value;

    // Si l'utilisateur est connecté et tente d'accéder à la page de connexion
    if (to.path === '/admin/log' && token && user) {
      return navigateTo('/admin/panel');
    }

    // Protection des routes admin
    if (to.path.startsWith('/admin')) {
      if (!token) {
        return navigateTo('/admin/log');
      }

      if (!user || !['ROLE_MANAGER', 'ROLE_ADMIN'].includes(user.role)) {
        return navigateTo('/');
      }
    }
  }
}); 
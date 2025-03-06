<template>
  <v-container fluid>
    <v-row>
      <!-- Menu latéral avec responsive -->
      <v-col cols="12" sm="4" md="3" lg="2">
        <div class="menu-container">
          <h2>Menu</h2>
          <v-list>
            <v-list-item>
              <v-list-item-title><a href="#">Tableau de bord</a></v-list-item-title>
            </v-list-item>
            <v-list-item>
              <v-list-item-title><a href="#">Utilisateurs</a></v-list-item-title>
            </v-list-item>
            <v-list-item>
              <v-list-item-title><a href="#">Produits</a></v-list-item-title>
            </v-list-item>
            <v-list-item>
              <v-list-item-title><a href="#">Categories</a></v-list-item-title>
            </v-list-item>
            <v-list-item>
              <v-list-item-title><a href="#">Paramètres</a></v-list-item-title>
            </v-list-item>
            <v-list-item>
              <v-list-item-title><a href="#">Déconnexion</a></v-list-item-title>
            </v-list-item>
          </v-list>
        </div>
      </v-col>
      
      <!-- Contenu principal avec responsive -->
      <v-col cols="12" sm="8" md="9" lg="10">
        <v-card v-if="isAuthorized" class="mb-4">
            <v-card-title>
                <h2 >Bienvenue {{ userProfile.firstName }}</h2>
          </v-card-title>
          <v-card>
            LOL
          </v-card>
        </v-card>
        <v-card v-else>
          <v-card-title>Accès Refusé</v-card-title>
          <v-card-text>
            <p>Vous n'avez pas les permissions nécessaires pour accéder à cette page.</p>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      userProfile: null,
      isAuthorized: false, // Initialiser à false
    };
  },
  mounted() {
    this.fetchUserProfile();
  },
  methods: {
    fetchUserProfile() {
      if (typeof window !== 'undefined') { // Vérification si nous sommes dans un environnement de navigateur
        const token = localStorage.getItem('token'); // Récupération du token stocké
        if (token) {
          fetch('http://localhost:8000/api/user/profile', {
            method: 'GET',
            headers: {
              'Authorization': `Bearer ${token}`,
              'Content-Type': 'application/json',
            },
          })
          .then(response => {
            if (!response.ok) {
              throw new Error('Erreur lors de la récupération du profil utilisateur');
            }
            return response.json();
          })
          .then(data => {
            this.userProfile = data; // Stockage des données du profil utilisateur
            this.checkAuthorization(); // Vérification de l'autorisation
          })
          .catch(error => {
            console.error(error);
          });
        } else {
          console.error('Token non trouvé');
        }
      } else {
        console.error('localStorage n\'est pas disponible');
      }
    },
    checkAuthorization() {
      // Vérification du rôle de l'utilisateur
      if (this.userProfile && (this.userProfile.role === 'ROLE_MANAGER' || this.userProfile.role === 'ROLE_ADMIN')) {
        this.isAuthorized = true; // Autoriser l'accès
      } else {
        this.isAuthorized = false; // Refuser l'accès
      }
    },
    editProfile() {
      // Logique pour modifier le profil
      console.log('Modifier le profil');
    },
    logout() {
      // Logique pour déconnexion
      console.log('Déconnexion');
    }
  },
};
</script>

<style scoped>
.v-container {
  min-height: 100vh;
  background: #ffffff;
  padding: 50px 20px;
  margin-top: 60px;
  position: relative;
}

h1 {
  font-size: 3.8rem;
  font-weight: 400;
  text-transform: uppercase;
  letter-spacing: 3px;
  text-align: center;
  color: #000000;
  margin: 60px 0;
  position: relative;
  font-family: 'Playfair Display', serif;
}

h2 {
  font-size: 2.6rem;
  font-weight: 400;
  text-align: center;
  color: #000000;
  margin-bottom: 30px;
  letter-spacing: 1px;
  font-family: 'Playfair Display', serif;
  position: relative;
}

h2::after {
  content: "";
  display: block;
  height: 1px;
  width: 60px;
  background: #000000;
  margin: 15px auto 0;
}

h3 {
  font-size: 1.6rem;
  font-weight: 400;
  
  color: #000000;
  margin-bottom: 30px;
  letter-spacing: 1px;
  font-family: 'Playfair Display', serif;
  position: relative;
}

.v-card {
  background: #ffffff;
  border: 1px solid rgba(0, 0, 0, 0.1);
  transition: all 0.4s ease;
  border-radius: 8px;
}


.v-btn {
  background: #000000;
  color: #ffffff;
  font-size: 1.1rem;
  padding: 12px 30px;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 1px;
  border-radius: 0;
  border: 1px solid #000000;
  transition: all 0.3s ease;
  font-family: 'Montserrat', sans-serif;
}

.v-btn:hover {
  background: #ffffff;
  color: #000000;
  transform: translateY(-2px);
}

.v-list {
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  transition: all 0.4s ease;
  background-color: #ffffff;
}

.v-list:hover {
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
}

.v-list-item {
  transition: all 0.3s ease;
  background-color: #ffffff;
}

.v-list-item:hover {
  background: rgba(0, 0, 0, 0.05);
}

.v-list-item a {
  color: #000000;
  text-decoration: none;
  font-family: 'Montserrat', sans-serif;
  font-size: 1rem;
  letter-spacing: 1px;
}

@media (max-width: 768px) {
  h1 {
    font-size: 2.5rem;
  }
  
  h2 {
    font-size: 2rem;
  }
}

/* Styles responsives */
.menu-container {
  position: sticky;
  top: 80px;
}

@media (max-width: 960px) {
  .v-container {
    padding: 30px 15px;
    margin-top: 40px;
  }

  h1 {
    font-size: 2.5rem;
    margin: 30px 0;
  }
  
  h2 {
    font-size: 1.8rem;
  }

  h3 {
    font-size: 1.4rem;
  }

  .menu-container {
    position: relative;
    top: 0;
    margin-bottom: 30px;
  }

  .v-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }

  .v-list-item {
    flex: 1 1 auto;
    min-width: 150px;
    text-align: center;
  }

  .v-btn {
    font-size: 0.9rem;
    padding: 8px 20px;
  }
}

@media (max-width: 600px) {
  .v-container {
    padding: 20px 10px;
    margin-top: 30px;
  }

  h1 {
    font-size: 2rem;
    margin: 20px 0;
  }
  
  h2 {
    font-size: 1.5rem;
  }

  h3 {
    font-size: 1.2rem;
  }

  .v-list {
    flex-direction: column;
  }

  .v-list-item {
    width: 100%;
  }

  .v-card {
    padding: 15px;
  }

  .v-btn {
    width: 100%;
    margin-bottom: 10px;
  }
}

/* Ajustements pour l'impression */
@media print {
  .menu-container {
    display: none;
  }

  .v-container {
    margin: 0;
    padding: 0;
  }

  .v-card {
    box-shadow: none !important;
    border: none !important;
  }
}
</style>



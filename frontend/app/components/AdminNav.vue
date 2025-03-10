<template>
<!-- Menu latéral avec responsive -->
<v-col cols="12" sm="4" md="3" lg="2">
    <div class="menu-container">
      <v-list>
        <v-list-item>
          <v-list-item-title>
            <NuxtLink to="/admin/dashboard">Tableau de bord</NuxtLink>
          </v-list-item-title>
        </v-list-item>
        <v-list-item>
          <v-list-item-title>
            <NuxtLink to="/admin/profile">Mon compte</NuxtLink>
          </v-list-item-title>
        </v-list-item>
        <v-list-item>
          <v-list-item-title>
            <NuxtLink to="/admin/users">Utilisateurs</NuxtLink>
          </v-list-item-title>
        </v-list-item>
        <v-list-item>
          <v-list-item-title>
            <NuxtLink to="/admin/products">Produits</NuxtLink>
          </v-list-item-title>
        </v-list-item>
        <v-list-item>
          <v-list-item-title> 
            <NuxtLink to="/admin/categories">Categories</NuxtLink>
          </v-list-item-title>
        </v-list-item>
        <v-list-item @click="handleLogout">
          <v-list-item-title>
            <a class="logout-link">Déconnexion</a>
          </v-list-item-title>
        </v-list-item>
      </v-list>
    </div>
  </v-col>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

const handleLogout = () => {
  // Supprimer le token du localStorage
  localStorage.removeItem('token');
  
  // Réinitialiser les états
  useState('token').value = null;
  useState('user').value = null;
  
  console.log(useState('token').value);
  // Rediriger vers la page de connexion
  router.push('/admin/log');
};
</script>

<style lang="css" scoped>

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
  
  h2 {
    font-size: 1.8rem;
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
}

@media (max-width: 600px) {

  
  h2 {
    font-size: 1.5rem;
  }
  .v-list {
    flex-direction: column;
  }

  .v-list-item {
    width: 100%;
  }
}

/* Ajustements pour l'impression */
@media print {
  .menu-container {
    display: none;
  }
}

.logout-link {
  color: #d32f2f !important;
}

.logout-link:hover {
  color: #b71c1c !important;
}
</style>
<template>
  <v-app-bar density="comfortable" style="background-color: rgba(0, 0, 0, 0.9);">
    <!-- Icône du menu burger (visible seulement en mobile) -->
    <v-btn icon @click="drawer = !drawer" class="d-md-none">
      <v-icon>{{ drawer ? 'mdi-close' : 'mdi-menu' }}</v-icon>
    </v-btn>

    <!-- Logo -->
    <v-col cols="8" md="4" class="logo-container">
      <nuxt-link to="/" class="logo-link">
        <img src="/assets/LogoWhite.png" alt="Logo">
      </nuxt-link>
    </v-col>

    <!-- Menu Desktop (centré) -->
    <div class="desktop-menu d-none d-md-flex">
      <nuxt-link v-for="item in menuItems" :key="item.text" :to="item.link" class="nav-link">
        {{ item.text }}
      </nuxt-link>
    </div>
    <v-spacer></v-spacer> <!-- Permet d'envoyer les icônes à droite -->
    <!-- Icônes Mon compte et Panier -->
    <div class="icons">
      <nuxt-link to="/account">
        <v-btn icon>
          <v-icon>mdi-account-circle</v-icon>
        </v-btn>
      </nuxt-link>
      <nuxt-link to="/cart">
        <v-btn icon>
          <v-icon>mdi-cart</v-icon>
        </v-btn>
      </nuxt-link>
    </div>
  </v-app-bar>

  <!-- Menu Burger (Drawer) -->
  <v-navigation-drawer v-model="drawer" temporary color="white">
    <v-list>
      <v-list-item v-for="item in menuItems" :key="item.text" :to="item.link" @click="drawer = false"
        class="drawer-item">
        {{ item.text }}
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
</template>

<script setup>
import { ref } from 'vue';

const drawer = ref(false);

const menuItems = [
  { text: 'Notre histoire', link: '/history' },
  { text: 'Nos produits', link: '/categories' },
  { text: 'Contact', link: '/contact' }
];
</script>

<style lang="css" scoped>
/* Centrer le menu en desktop */
.desktop-menu {
  display: flex;
  gap: 60px;
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
}

/* Style des liens du menu */
.nav-link {
  position: relative;
  font-size: 16px;
  font-weight: 400;
  color: white;
  text-decoration: none;
  padding: 5px 0;
  text-transform: uppercase;
  letter-spacing: 1px;
  transition: all 0.3s ease-in-out;
}

/* Effet de survol : ligne blanche qui part du centre */
.nav-link::after {
  content: "";
  position: absolute;
  left: 50%;
  bottom: -2px;
  width: 0;
  height: 1px;
  background-color: white;
  transition: all 0.3s ease-in-out;
  transform: translateX(-50%);
}

.nav-link:hover {
  color: rgba(255, 255, 255, 0.8);
}

.nav-link:hover::after {
  width: 100%;
}

/* Style des liens dans le menu burger */
.drawer-item {
  color: #555;
  /* Gris */
  font-size: 18px;
  font-weight: 500;
  transition: background 0.3s ease-in-out;
}

/* Effet de survol */
.drawer-item:hover {
  background-color: #f5f5f5;
  /* Gris clair */
}

/* Icônes Mon Compte et Panier */
.icons {
  display: flex;
  align-items: center;
  gap: 15px;
}

.icons v-icon {
  font-size: 28px;
  color: white;
}

.logo-link img {
  transition: transform 0.3s ease-in-out;
  width: auto;
  height: 50px;
  max-width: 130px;
  object-fit: contain;
}

.logo-link:hover img {
  transform: scale(1.1);
}

/* Empêcher le style par défaut de Nuxt sur les liens */
.icons a {
  text-decoration: none;
  color: inherit;
}

.icons v-icon {
  font-size: 28px;
  color: white !important;
}

.logo-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  /* S'assure que le conteneur prend toute la hauteur du header */
}
</style>

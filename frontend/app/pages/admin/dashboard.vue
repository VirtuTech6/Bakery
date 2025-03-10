<template>
  <v-container fluid>
    <v-row>
      <AdminNav />
      <v-col class="v-col" cols="12" sm="8" md="9" lg="10">
        <v-card>
          <v-card-title>Tableau de bord</v-card-title>
          <v-card-text>
            <p>Bienvenue dans votre espace d'administration</p>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import AdminNav from '~/components/AdminNav.vue';

definePageMeta({
  middleware: ['admin']
});
</script>

<style scoped>
.v-container {
  min-height: 100vh;
  background: #ffffff;
  padding: 50px 20px;
  margin-top: 60px;
  position: relative;
}

.v-card {
  background: #ffffff;
  border: 1px solid rgba(0, 0, 0, 0.1);
  transition: all 0.4s ease;
  border-radius: 8px;
}

@media (max-width: 960px) {
  .v-container {
    padding: 30px 15px;
    margin-top: 40px;
  }
}

@media (max-width: 600px) {
  .v-container {
    padding: 20px 10px;
    margin-top: 30px;
  }

  .v-card {
    padding: 15px;
  }
}

@media print {
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



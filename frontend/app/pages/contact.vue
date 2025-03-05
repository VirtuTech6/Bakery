<template>
    <v-container class="py-10 artisan-container">
      <h1 class="text-center artisan-title">
        Une idée, <br /> une remarque, <br /> une question ?
      </h1>
      
      <v-row justify="center">
        <v-col cols="12" md="8">
          <v-card class="pa-6 artisan-card" elevation="0">
            <v-form @submit.prevent="submitForm">
              <v-text-field v-model="form.nom" label="Nom" required outlined dense class="artisan-input"></v-text-field>
              <v-text-field v-model="form.prenom" label="Prénom" required outlined dense class="artisan-input"></v-text-field>
              <v-text-field 
                v-model="form.email" 
                label="Email" 
                :rules="emailRules" 
                required 
                outlined 
                dense 
                type="email"
                class="artisan-input">
              </v-text-field>
              <v-text-field v-model="form.telephone" label="Téléphone" required outlined dense type="tel" class="artisan-input"></v-text-field>
              <v-text-field v-model="form.adresse" label="Adresse" outlined dense class="artisan-input"></v-text-field>
              <v-text-field v-model="form.codePostal" label="Code Postal" required outlined dense class="artisan-input"></v-text-field>
              <v-text-field v-model="form.ville" label="Ville" outlined dense class="artisan-input"></v-text-field>
              
              <v-select v-model="form.objet" :items="objets" label="Objet" required outlined dense class="artisan-input"></v-select>
              
              <v-textarea v-model="form.message" label="Message" required outlined dense class="artisan-input"></v-textarea>
              
              <v-btn class="artisan-btn" block type="submit" :loading="isSubmitting" :disabled="isSubmitting">
                Envoyer la demande
              </v-btn>
            </v-form>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const form = ref({
    nom: '',
    prenom: '',
    email: '',
    telephone: '',
    adresse: '',
    codePostal: '',
    ville: '',
    objet: '',
    message: ''
  });
  
  const isSubmitting = ref(false);
  const objets = ['Retour client', 'Demande d\'information'];
  
  const emailRules = [
    (v) => !!v || 'Email requis',
    (v) => /.+@.+\..+/.test(v) || 'Email invalide'
  ];
  
  const submitForm = () => {
    isSubmitting.value = true;
    console.log('Formulaire soumis avec :', form.value);
  
    // Simuler un délai pour l'envoi
    setTimeout(() => {
      alert('Votre demande de contact a bien été envoyée.');
      isSubmitting.value = false;
    }, 2000);
  };
  </script>
  
  <style scoped>
  .artisan-container {
    min-height: 100vh;
    background: #ffffff;
    padding: 50px 20px;
    margin-top: 60px;
    position: relative;
  }

  .artisan-title {
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

  .artisan-title::after {
    content: "";
    display: block;
    width: 100px;
    height: 1px;
    background: #000000;
    margin: 20px auto 0;
  }

  .artisan-card {
    background: #ffffff;
    border: 1px solid rgba(0, 0, 0, 0.1);
    transition: all 0.4s ease;
  }

  .artisan-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
  }

  .artisan-btn {
    background: #000000;
    color: #ffffff;
    font-size: 1.1rem;
    padding: 15px 40px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-radius: 0;
    border: 1px solid #000000;
    transition: all 0.3s ease;
    font-family: 'Montserrat', sans-serif;
  }

  .artisan-btn:hover {
    background: #ffffff;
    color: #000000;
    transform: translateY(-2px);
  }

  /* Styles Vuetify optimisés */
  :deep(.v-label) {
    color: rgba(0, 0, 0, 0.8) !important;
  }

  :deep(.v-field__input) {
    color: #000000 !important;
  }

  :deep(.v-field__outline) {
    color: rgba(0, 0, 0, 0.2) !important;
  }

  :deep(.v-field--focused .v-field__outline) {
    color: #000000 !important;
  }

  .artisan-input {
    margin-bottom: 16px;
  }

  /* Ajout d'un effet de texture subtil */
  .artisan-container::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23000000' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
    pointer-events: none;
    z-index: 0;
  }
  </style>
  
<template>
    <v-container class="py-10 mt-10">
      <h1 class="text-h4 font-weight-bold text-center mb-6">
        Une idée, <br /> une remarque, <br /> une question ?
      </h1>
      
      <v-row justify="center">
        <v-col cols="12" md="8">
          <v-card class="pa-6" elevation="2">
            <v-form @submit.prevent="submitForm">
              <v-text-field v-model="form.nom" label="Nom" required outlined dense></v-text-field>
              <v-text-field v-model="form.prenom" label="Prénom" required outlined dense></v-text-field>
              <v-text-field 
                v-model="form.email" 
                label="Email" 
                :rules="emailRules" 
                required 
                outlined 
                dense 
                type="email">
              </v-text-field>
              <v-text-field v-model="form.telephone" label="Téléphone" required outlined dense type="tel"></v-text-field>
              <v-text-field v-model="form.adresse" label="Adresse" outlined dense></v-text-field>
              <v-text-field v-model="form.codePostal" label="Code Postal" required outlined dense></v-text-field>
              <v-text-field v-model="form.ville" label="Ville" outlined dense></v-text-field>
              
              <v-select v-model="form.objet" :items="objets" label="Objet" required outlined dense></v-select>
              
              <v-textarea v-model="form.message" label="Message" required outlined dense></v-textarea>
              
              <v-btn color="primary" block type="submit" :loading="isSubmitting" :disabled="isSubmitting">
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
  .v-container {
    max-width: 800px;
    margin-top: 80px;
  }
  </style>
  
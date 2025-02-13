<template>
  <footer class="footer">
    <v-container>
      <v-row class="align-center">
        <!-- Colonne de gauche : Adresse, Téléphone & Bouton Contact -->
        <v-col cols="12" md="5" class="footer-info">
          <h3>Boulogne sur mer</h3>
          <p>87 rue faidherbe, 62200</p>

          <h3>Contact</h3>
          <p>📞 <a href="tel:+33123456789">01 23 45 67 89</a></p>

          <!-- Bouton Contactez-nous -->
          <v-btn class="contact-btn" to="/contact">
            Contactez-nous
          </v-btn>
        </v-col>

        <!-- Colonne de droite : Google Maps + Réseaux sociaux -->
        <v-col cols="12" md="5" class="footer-map">
          <!-- Placeholder Google Maps -->
          <div class="map-placeholder"><iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2525.683128507884!2d1.603613076758401!3d50.72581757164603!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47dc2c41537ea3e7%3A0xca7247ec9e59a43c!2sMaison%20Musial!5e0!3m2!1sfr!2sfr!4v1739183017915!5m2!1sfr!2sfr"
              width="100%" height="100%" style="border:0;" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe></div>

          <!-- Icônes Réseaux Sociaux -->
          <div class="social-icons">
            <a href="https://www.instagram.com" target="_blank">
              <v-icon size="26">mdi-instagram</v-icon>
            </a>
            <a href="https://www.facebook.com" target="_blank">
              <v-icon size="26">mdi-facebook</v-icon>
            </a>
          </div>
        </v-col>
      </v-row>
    </v-container>
  </footer>
</template>

<style lang="css" scoped>
.footer {
  background-color: rgba(81, 42, 22, 0.8);
  color: white;
  text-align: center;
  padding: 10px 0;
}

.footer-info h3 {
  font-size: 16px;
  margin-bottom: 5px;
}

.footer-info p {
  font-size: 14px;
  margin: 2px 0;
}

.footer-info a {
  color: white;
  text-decoration: none;
}

.contact-btn {
  margin-top: 8px;
  transition: transform 0.3s ease-in-out;
  /* Animation fluide */
  background-color: orange;
  color: white;
  font-size: 14px;
  padding: 5px 15px;
  font-weight: bold;
  text-transform: uppercase;
}

.contact-btn:hover {
  background-color: #e69500;
  transform: scale(1.1);
  /* Zoom léger au survol */
}

.footer-map {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.map-placeholder {
  width: 100%;
  height: 150px;
  background: #ddd;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  color: #444;
  border-radius: 8px;
}

.social-icons {
  margin-top: 10px;
  display: flex;
  gap: 10px;
}

.social-icons a {
  color: white;
  transition: transform 0.3s;
}

.social-icons a:hover {
  transform: scale(1.1);
}
</style>

<template>
  <footer class="footer">
    <v-container>
      <v-row class="align-center">
        <!-- Colonne de gauche : Adresse, Téléphone & Bouton Contact -->
        <v-col cols="12" md="5" class="footer-info">
          <h3>Boulogne sur mer</h3>
          <p>87 rue faidherbe, 62200</p>

          <h3>Contact</h3>
          <p><a href="tel:+33123456789">01 23 45 67 89</a></p>

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
  background-color: rgba(0, 0, 0, 0.9);
  color: white;
  text-align: center;
  padding: 20px 0;
}

.footer-info h3 {
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 8px;
  font-weight: 500;
}

.footer-info p {
  font-size: 14px;
  margin: 4px 0;
  opacity: 0.8;
}

.footer-info a {
  color: white;
  text-decoration: none;
  transition: opacity 0.3s ease;
}

.footer-info a:hover {
  opacity: 0.7;
}

.contact-btn {
  margin-top: 15px;
  transition: all 0.3s ease-in-out;
  background-color: transparent !important;
  color: white;
  font-size: 13px;
  padding: 8px 20px;
  font-weight: 400;
  text-transform: uppercase;
  letter-spacing: 1px;
  border: 1px solid white !important;
}

.contact-btn:hover {
  background-color: white !important;
  color: black !important;
  transform: translateY(-2px);
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
  background: #111;
  border-radius: 4px;
  overflow: hidden;
}

.social-icons {
  margin-top: 15px;
  display: flex;
  gap: 20px;
}

.social-icons a {
  color: white;
  opacity: 0.8;
  transition: all 0.3s ease;
}

.social-icons a:hover {
  opacity: 1;
  transform: translateY(-2px);
}
</style>

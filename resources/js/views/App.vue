<template>
  <v-app id="inspire">

    <v-navigation-drawer  v-model="drawer" clipped  class="elevation-10" app>
      <v-list dense>

        <template v-for="item in items">
            <router-link :to="{name: item.page }" :key="item.text" >
          <v-list-item  link>
            <v-list-item-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{ item.text }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          </router-link> 
        </template>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar clipped-left class="elevation-10" app>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-img
        src="https://oplus.pacificmedicalsuite.com/pacific-saas/images/home/pms-logo.png"
        position="start"
        height="35px"
        contain
      ></v-img>
      <v-spacer></v-spacer>

      <v-btn icon>
        <v-icon>mdi-bell</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon>mdi-heart</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon x-large>mdi-account-circle</v-icon>
      </v-btn>
    </v-app-bar>


     <v-content >
      <router-view/>
    </v-content>

  </v-app>
</template>

<script>
export default {
  props: {
    source: String
  },
  data: () => ({
    drawer: false,
    items: [
      { icon: "mdi-contacts", text: "Tipos de perfiles", page : "profiletype"},
      { icon: "mdi-contacts", text: "Tipos de consulta" , page : "slottype"},
      { icon: "mdi-contacts", text: "Estructura organizacional" , page : "orgstructure"},
  
    ]
  })
};
</script>
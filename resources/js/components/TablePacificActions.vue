<template >
 
  <v-card class="elevation-10">
 

    <v-card-title>
      <h1 class="titleinf">Lista de Perfiles</h1>
      <div class="filters">
        <v-select v-model="filterState" :items="keys" label="Estado" single-line hide-details></v-select>
        <v-text-field
          v-model="filterSearch"
          append-icon="mdi-magnify"
          label="Buscar"
          single-line
          hide-details
          
        ></v-text-field>
      </div>
    </v-card-title>

    <v-data-table :headers="headers" :items="profileTypes" :items-per-page="5" class="elevation-2">
      <template v-slot:item.state="{ item }">
        <div class="act" v-if="item.state">@
          <v-icon medium color="success">mdi-checkbox-blank-circle</v-icon>
        </div>

        <div class="act" v-else>
          <v-icon medium>mdi-checkbox-blank-circle</v-icon>
        </div>
      </template>

      <template v-slot:item.actions="{ item }">
        <div class="act">
          <v-switch
            v-model="item.state"
            @change="createEditProfileType(item) "
            color="success"
            hide-details
          ></v-switch>
          <v-icon medium @click="open('Editar tipo de perfil', item )">mdi-pencil</v-icon>
          <v-icon medium @click="opendelete(item)">mdi-delete</v-icon>
  
        </div>
      </template>

      <template v-slot:no-data>
        <h5>No se encontraron datos</h5>
      </template>
    </v-data-table>

    <template class="btn-create">
      <v-btn
        @click="open('Crear tipo de perfil' )"
        class="mx-2"
        fab
        dark
        color="deep-purple accent-3"
      >
        <v-icon dark>mdi-plus</v-icon>
      </v-btn>
    </template>

    <!-- modal -->
    <template class="modal-createEdit">
      <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card>
          <form action @submit="createProfileType(editedItem,id)">
            <v-card-title>
              <span class="headline">{{formTitle}}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-col>
                  <v-row>
                    <v-text-field
                      :error-messages="nameErrors"
                      v-model="editedItem.name"
                      label="Nombre *"
                      required
                    ></v-text-field>
                  </v-row>
                  <v-row>
                    <v-textarea
                      :error-messages="descriptionErrors"
                      v-model="editedItem.description"
                      label="Descripciòn *"
                      hint="Agrega una descripciòn"
                    ></v-textarea>
                  </v-row>
                  <v-row>
                    <v-switch
                      v-model="editedItem.state"
                      :label="`Estado: ${editedItem.state?'Activo':'No activo'}`"
                    ></v-switch>
                  </v-row>
                </v-col>
              </v-container>
              <small>*estos campos son requeridos</small>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">Cancelar</v-btn>
              <v-btn
                color="blue darken-1"
                text
                @click.prevent="createEditProfileType(editedItem)"
              >Guardar</v-btn>
            </v-card-actions>
          </form>
        </v-card>
      </v-dialog>
    </template>
    <!--  -->
    <!-- modal -->
    <template class="modal-delete">
      <v-dialog v-model="alertDelete" persistent max-width="400px">
        <v-card>
          
            <v-card-title>
              <span class="headline">Borrar?</span>
            </v-card-title>

            <v-card-text>
              Estas seguro de borrar este item?
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closedelete">Cancelar</v-btn>
              <v-btn
                color="blue darken-1"
                text
                @click="deleteProfileType(deleteItem)"
              >Borrar</v-btn>
            </v-card-actions>
       
        </v-card>
      </v-dialog>
    </template>
    <!--  -->
  </v-card>
</template>



<script>
import { mapGetters } from "vuex";

export default {
  data: () => ({
    alertDelete: false,
    dialog: false,
    filterSearch: "",
    filterState: null,
    formTitle: "",
    keys: [
      { text: "Todos", value: null },
      { text: "Activo", value: true },
      { text: "No activo", value: false }
    ],
    erroresFormulario: [
    ],
    editedItem: {
      name: "",
      description: "",
      state: true,
      lang: "es_co"
    },
    deleteItem:{
    },
    validations: {
    }
  }),

  mounted() {
    this.$store.dispatch("fetchProfileType");
  },

  methods: {
    filterSearchFunction(value) {
      if (!this.filterSearch) {
        return true;
      }
      return value.toLowerCase().includes(this.filterSearch.toLowerCase());
    },

    filterStateFunction(value) {
      if (this.filterState == null) {
        return true;
      }
      return value === this.filterState;
    },

    createEditProfileType(pt) {
      this.erroresFormulario = [];
      if (pt.id == -1) {
        this.$store.dispatch("createProfileType", pt).then(data => {
          if (data != undefined) {
            this.erroresFormulario = data;
          }
          if (this.erroresFormulario.length == 0) {
            this.close();
          } else {
            this.reopen(this.title, this.editedItem);
          }
        });
      } else {
        this.$store.dispatch("editProfileType", pt).then(data => {
          if (data != undefined) {
            this.erroresFormulario = data;
          }
          if (this.erroresFormulario.length == 0) {
            this.close();
          } else {
            this.reopen(this.title, this.editedItem);
          }
        });
      }
    },

    deleteProfileType(pt) {
      this.$store.dispatch("deleteProfileType", pt);
      this.alertDelete= false
    },

    open(title, item) {
      this.erroresFormulario = [];
      const defaultItem = {
        id: item ? item.id : -1,
        name: item ? item.name : "",
        description: item ? item.description : "",
        state: item ? item.state : true,
        lang: item ? item.lang : "es_co"
      };
      this.editedItem = defaultItem;
      this.formTitle = title;
      this.dialog = true;
    },

    reopen(title, item) {
      const defaultItem = {
        id: item ? item.id : -1,
        name: item ? item.name : "",
        description: item ? item.description : "",
        state: item ? item.state : true,
        lang: item ? item.lang : "es_co"
      };
      this.editedItem = defaultItem;
      this.formTitle = title;
      this.dialog = true;
    },

    close() {
      this.dialog = false;
    },

    opendelete(item) {
      this.alertDelete= true
      this.deleteItem= item
    },
    
    closedelete() {
      this.alertDelete = false;
    },
 
  },

  computed: {
    ...mapGetters(["profileTypes"]),
    headers() {
      return [
        {
          text: "Estado",
          align: "start",
          sortable: true,
          value: "state",
          width: "10%",
          filter: this.filterStateFunction
        },

        {
          text: "Nombre",
          align: "start",
          sortable: true,
          value: "name",
          width: "25%",
          filter: this.filterSearchFunction
        },
        {
          text: "Descripcion",
          align: "start",
          sortable: true,
          value: "description",
          width: "45%"
        },
        {
          text: "Acciones",
          value: "actions",
          align: "center",
          sortable: false,
          width: "20%"
        }
      ];
    },

    nameErrors() {
      var e = [];
      if (this.erroresFormulario.name != undefined) {
        var json = JSON.parse(JSON.stringify(this.erroresFormulario.name));
        json.forEach(element => {
          e.push(element);
          console.log(e);
        });
      }
      return e;
    },

    descriptionErrors() {
      var e = [];
      if (this.erroresFormulario.description != undefined) {
        var json = JSON.parse(
          JSON.stringify(this.erroresFormulario.description)
        );
        json.forEach(element => {
          e.push(element);
          console.log(e);
        });
      }
      return e;
    }
  }
};
</script>
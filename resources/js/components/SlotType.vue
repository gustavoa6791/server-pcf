<template >
  <v-card class="elevation-10 conteiner" max-width="1000" >
    <v-card-title>
      <h1 class="titleinf">Tipos de consultas</h1>
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

    <v-data-table :headers="headers" :items="slotTypes" :items-per-page="5" class="elevation-2">
      <template v-slot:item.gbl_status_id="{ item }">
        <div class="act" v-if="item.gbl_status_id=='1'">
          <v-icon medium color="success">mdi-checkbox-blank-circle</v-icon>
        </div>

        <div class="act" v-if="item.gbl_status_id=='0'">
          <v-icon medium>mdi-checkbox-blank-circle</v-icon>
        </div>
      </template>

      <template v-slot:item.actions="{ item }">
        <div class="act">
          <v-switch
            v-model="item.gbl_status_id"
            @change="createEditProfileType(item) "
            color="success"
            true-value="1"
            false-value="0"
            hide-details
          ></v-switch>
          <router-link    :to="{ name: 'slottypedetails', params: { slot: item }}" >
            <v-icon large >mdi-eye</v-icon>
          </router-link>

          <!-- <v-icon medium @click="open('Editar tipo de perfil', item )">mdi-pencil</v-icon>
          <v-icon medium @click="opendelete(item)">mdi-delete</v-icon>-->
        </div>
      </template>

      <template v-slot:no-data>
        <h5>No se encontraron datos</h5>
      </template>
    </v-data-table>

    <template class="btn-create">
      <v-btn
        @click="open('Crear tipo de Consulta' )"
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
          <form @submit="createSlotType(editedItem)">
            <v-card-text>
              <div class="encabezado">
                <span class="headline">{{formTitle}}</span>
              </div>

              <v-row>
                <v-col>
                  <v-text-field
                    :error-messages="nameErrors"
                    v-model="editedItem.code"
                    label="Codigo *"
                    hint="Agrega un codigo"
                    outlined
                    dense
                  ></v-text-field>
                </v-col>
                <v-col>
                  <v-text-field
                    :error-messages="descriptionErrors"
                    v-model="editedItem.description"
                    label="Nombre *"
                    hint="Agrega una nombre"
                    outlined
                    dense
                  ></v-text-field>
                </v-col>
              </v-row>

              <v-row>
                <v-col>
                  <v-text-field
                    :error-messages="nameErrors"
                    v-model="editedItem.duration_default"
                    label="Duracion(Min) *"
                    hint="Agrega una duracion"
                    outlined
                    dense
                  ></v-text-field>
                </v-col>
                <v-col>
                  <v-text-field
                    :error-messages="descriptionErrors"
                    v-model="editedItem.max_assign_allow"
                    label="Numero de pacientes por turno*"
                    hint="Agrega un numero de pacientes"
                    outlined
                    dense
                    type="number"
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-switch
                  v-model="editedItem.gbl_status_id"
                  true-value="1"
                  false-value="0"
                  :label="`Estado: ${editedItem.gbl_status_id=='1'?'Activo':'No activo'}`"
                ></v-switch>
              </v-row>
              <v-divider />
              <div class="encabezado">
                <span class="headline">Datos Adicionales</span>
              </div>

              <v-row>
                <v-col>
                  <v-text-field label="Asegurador *" hint="Agrega un asegurador" outlined dense></v-text-field>
                </v-col>
                <v-col>
                  <v-text-field
                    label="Plan de Atencion"
                    hint="Agrega un Plan de Atencion"
                    outlined
                    dense
                  ></v-text-field>
                </v-col>
              </v-row>

              <v-row>
                <v-col>
                  <v-text-field
                    label="Tiempo Limite de Espera*"
                    hint="Agrega un codigo"
                    outlined
                    dense
                  ></v-text-field>
                </v-col>
                <v-col></v-col>
              </v-row>
              <v-row>
                <v-col>
                  <v-textarea
                    label="Mensajes / Recomendaciones *"
                    hint="Agrega un Mensaje o Recomendacion"
                    outlined
                    dense
                    height="100"
                  ></v-textarea>
                </v-col>
              </v-row>
            </v-card-text>

            <v-card-actions>
              <small>*estos campos son requeridos</small>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">Cancelar</v-btn>
              <v-btn
                color="blue darken-1"
                text
                @click.prevent="createEditSlotType(editedItem)"
              >Agregar</v-btn>
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

          <div class="ver" v-if="deleteItem.verify=='delete'">
            <v-card-text>Estas seguro de borrar este tipo de perfil</v-card-text>
          </div>
          <div class="ver" v-if="deleteItem.verify=='perfil.activo'">
            <v-card-text>Este tipo de Perfil no se puede borrar.Esta asignado a un perfil activo</v-card-text>
          </div>
          <div class="ver" v-if="deleteItem.verify=='perfil.noActivo'">
            <v-card-text>Este tipo de perfil esta asignado a un perfil no activo. Esta seguro de borrarlo</v-card-text>
          </div>

          <div class="ver" v-if="deleteItem.verify=='perfil.activo'">
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closedelete">Entendido</v-btn>
            </v-card-actions>
          </div>

          <div class="ver" v-else>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closedelete">Cancelar</v-btn>
              <v-btn color="blue darken-1" text @click="deleteProfileType(deleteItem)">Borrar</v-btn>
            </v-card-actions>
          </div>
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
      { text: "Activo", value: "1" },
      { text: "No activo", value: "0" }
    ],
    erroresFormulario: [],
    editedItem: {
      code: "",
      description: "",
      duration_default: "",
      max_assign_allow: "",
      gbl_status_id: "1",
      lang: "es_CO"
    },
    deleteItem: {},
    validations: {}
  }),

  mounted() {
    this.$store.dispatch("fetchSlotType");
  },

  methods: {
    filterSearchFunction(value) {
      if (!this.filterSearch) {
        return true;
      }
      return value.toLowerCase().includes(this.filterSearch.toLowerCase());
    },

    filterStateFunction(value) {
      if (!this.filterState) {
        return true;
      }
      return value === this.filterState;
    },

    createEditSlotType(pt) {
      this.erroresFormulario = [];
      if (pt.id == -1) {
        this.$store.dispatch("createSlotType", pt).then(data => {
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
      this.alertDelete = false;
    },

    open(title, item) {
      this.erroresFormulario = [];
      const defaultItem = {
        id: item ? item.id : -1,
        code: item ? item.code : "",
        description: item ? item.description : "",
        gbl_status_id: item ? item.gbl_status_id : "1",
        lang: item ? item.lang : "es_CO",
        duration_default: item ? item.duration_default : "",
        max_assign_allow: item ? item.max_assign_allow : ""
      };

      this.editedItem = defaultItem;
      this.formTitle = title;
      this.dialog = true;
    },

    reopen(title, item) {
      const defaultItem = {
        id: item ? item.id : -1,
        code: item ? item.code : "",
        description: item ? item.description : "",
        gbl_status_id: item ? item.gbl_status_id : "1",
        lang: item ? item.lang : "es_CO",
        duration_default: item ? item.duration_default : "",
        max_assign_allow: item ? item.max_assign_allow : ""
      };
      this.editedItem = defaultItem;
      this.formTitle = title;
      this.dialog = true;
    },

    close() {
      this.dialog = false;
    },

    opendelete(item) {
      this.$store.dispatch("deleteVerifyProfileType", item).then(data => {
        item.verify = data;
        this.deleteItem = item;
        this.alertDelete = true;
      });
    },

    closedelete() {
      this.alertDelete = false;
    }
  },

  computed: {
    ...mapGetters(["slotTypes"]),
    headers() {
      return [
        {
          text: "Estado",
          align: "start",
          sortable: false,
          value: "gbl_status_id",
          width: "10%"
          //filter: this.filterStateFunction
        },

        {
          text: "Codigo",
          align: "start",
          sortable: true,
          value: "code",
          width: "15%"
          //filter: this.filterSearchFunction
        },
        {
          text: "Tipo de Consulta",
          align: "start",
          sortable: true,
          value: "description",
          width: "30%"
        },
        {
          text: "Duracion(Min)",
          value: "duration_default",
          align: "center",
          sortable: true,
          width: "10%"
        },
        {
          text: "Numero de pacientes por turno",
          value: "max_assign_allow",
          align: "center",
          sortable: true,
          width: "20%"
        },
        {
          text: "Acciones",
          value: "actions",
          align: "center",
          sortable: false,
          width: "15%"
        }
      ];
    },

    nameErrors() {
      var e = [];
      if (this.erroresFormulario.name != undefined) {
        var json = JSON.parse(JSON.stringify(this.erroresFormulario.name));
        json.forEach(element => {
          console.log(element);
          switch (element) {
            case "The name has already been taken.":
              e.push("El nombre ya existe");
              break;
            case "The name field is required.":
              e.push("El campo nombre es requerido");
              break;
            case "The name may not be greater than 50 characters.":
              e.push("El nombre no puede tener más de 50 caracteres.");
              break;
            default:
              e.push("ha ocurrido un error");
              break;
          }
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
          console.log(element);
          switch (element) {
            case "The description field is required.":
              e.push("El campo descripciòn es requerido");
              break;
            case "The description may not be greater than 255 characters.":
              e.push("El descripciòn no puede tener más de 255 caracteres.");
              break;
            default:
              e.push("ha ocurrido un error");
              break;
          }
        });
      }
      return e;
    }
  }
};
</script>
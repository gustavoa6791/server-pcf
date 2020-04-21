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
        @click="open()"
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
                <span class="headline">Crear Tipo de Consulta</span>
              </div>

              <v-row>
                <v-col>
                  <v-text-field
                
                    v-model="editedItem.code"
                    label="Codigo *"
                    hint="Agrega un codigo"
                    outlined
                    dense
                  ></v-text-field>
                </v-col>
                <v-col>
                  <v-text-field
              
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
            
                    v-model="editedItem.duration_default"
                    label="Duracion(Min) *"
                    hint="Agrega una duracion"
                    outlined
                    dense
                  ></v-text-field>
                </v-col>
                <v-col>
                  <v-text-field
  
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
                  <v-text-field  v-model="editedItem.entity_name" label="Asegurador *" hint="Agrega un asegurador" outlined dense></v-text-field>
                </v-col>
                <v-col>
                  <v-text-field
                    v-model="editedItem.plan_name"
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
                    v-model="editedItem.limit_attention"
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
                    v-model="editedItem.reminder_email"
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

  </v-card>
</template>



<script>
import { mapGetters } from "vuex";

export default {
  data: () => ({
  
    dialog: false,
    filterSearch: "",
    filterState: null,
  
    keys: [
      { text: "Todos", value: null },
      { text: "Activo", value: "1" },
      { text: "No activo", value: "0" }
    ],
    erroresFormulario: [],
    editedItem: {
        id: "",
        code: "",
        description: "",
        duration_default: "",
        max_assign_allow: "",
        gbl_status_id: "",
        entity_name: "",
        plan_name: "",
        limit_attention: "",
        reminder_email: "",
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
      
    },

    open() {
      this.erroresFormulario = [];
      const defaultItem = {
        id: -1,
        code: "",
        description: "",
        duration_default: "",
        max_assign_allow: "",
        gbl_status_id: "1",
        entity_name: "",
        plan_name: "",
        limit_attention: "",
        reminder_email: "",
        lang: "es_CO"
      };

      this.editedItem = defaultItem;

      this.dialog = true;
    },

    reopen( item) {
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
          width: "10%",
          filter: this.filterStateFunction
        },

        {
          text: "Codigo",
          align: "start",
          sortable: true,
          value: "code",
          width: "15%"
       
        },
        {
          text: "Tipo de Consulta",
          align: "start",
          sortable: true,
          value: "description",
          width: "30%",
          filter: this.filterSearchFunction
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



  }
};
</script>
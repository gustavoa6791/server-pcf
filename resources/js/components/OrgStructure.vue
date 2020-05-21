<template >
  <v-card class="elevation-10 conteiner" max-width="1000">
    <v-spacer></v-spacer>
    <br />
    <v-card-title>
      <h1 class="titleinf">Estructura Organizacional</h1>
      <div class="filters"></div>
    </v-card-title>

    <v-expansion-panels :multiple="true">
      <v-expansion-panel v-for="(item,i) in orgStructure" :key="i">
        <v-expansion-panel-header>
          <div class="headStructure">
            <div v-if="item.gbl_status_id=='1'">
              <v-icon medium color="success">mdi-checkbox-blank-circle</v-icon>
            </div>
            <div v-if="item.gbl_status_id=='0'">
              <v-icon medium>mdi-checkbox-blank-circle</v-icon>
            </div>
            <v-btn @click="showItem('Sede', item )" large icon>
              <v-icon medium>mdi-eye</v-icon>
            </v-btn>
            <div>{{item.name}}</div>
            <div></div>
          </div>
        </v-expansion-panel-header>
        <v-expansion-panel-content>
          <v-data-table
            :headers="headers"
            :items="item.admission"
            show-expand
            hide-default-footer
            class="table-structure"
          >
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
                <v-btn large icon>
                  <v-icon medium>mdi-eye</v-icon>
                </v-btn>
              </div>
            </template>
            <template v-slot:no-data >
              <v-btn x-small fab dark color="deep-purple accent-3">
                <v-icon @click="openAdmission('Crear Punto de Admision',item.id)" small>mdi-plus</v-icon>
              </v-btn>
            </template>

            <template v-slot:expanded-item="{ headers, item }">
              <td class="tab-structure" :colspan="headers.length">
                <v-data-table
                  :headers="headersAtt"
                  :items="item.attention"
                  hide-default-footer
                  class="table-structure"
                >
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
                      <v-btn large icon>
                        <v-icon medium>mdi-eye</v-icon>
                      </v-btn>
                    </div>
                  </template>
                  <template v-slot:no-data>
                    <v-btn x-small fab dark color="deep-purple accent-3">
                      <v-icon small>mdi-plus</v-icon>
                    </v-btn>
                  </template>
                </v-data-table>
              </td>
            </template>
          </v-data-table>
        </v-expansion-panel-content>
      </v-expansion-panel>
    </v-expansion-panels>

    <template class="btn-create">
      <v-btn @click="openSede('Crear Sede')" class="mx-2" fab dark color="deep-purple accent-3">
        <v-icon dark>mdi-plus</v-icon>
      </v-btn>
    </template>

    <!-- modal -->
    <template class="modal-createEdit">
      <v-dialog v-model="createEdit" persistent max-width="600px">
        <v-card>
          <form action @submit="createSede(editedItem)">
            <v-card-title>
              <span class="headline">{{formTitle}}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-col>
                  <v-row>
                    <v-text-field
                      v-model="editedItem.code"
                      label="Codigo *"
                      hint="Agrega un Codigo"
                    ></v-text-field>
                  </v-row>
                  <v-row>
                    <v-text-field
                      v-model="editedItem.name"
                      label="Nombre *"
                      hint="Agrega un Nombre"
                    ></v-text-field>
                  </v-row>
                  <v-row>
                    <v-textarea
                      v-model="editedItem.description"
                      label="Descripciòn"
                      hint="Agrega una Descripciòn"
                    ></v-textarea>
                  </v-row>
                  <v-row>
                    <v-switch
                      v-model="editedItem.gbl_status_id"
                      true-value="1"
                      false-value="0"
                      color="success"
                      :label="`Estado: ${editedItem.gbl_status_id=='1'?'Activo':'No activo'}`"
                    ></v-switch>
                  </v-row>
                </v-col>
              </v-container>
              <small>*estos campos son requeridos</small>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">Cancelar</v-btn>
              <v-btn color="blue darken-1" text @click.prevent="createSede(editedItem)">Guardar</v-btn>
            </v-card-actions>
          </form>
        </v-card>
      </v-dialog>
    </template>
    <!--  -->
    <!-- modal -->
    <template class="modal-show">
      <v-dialog v-model="show" persistent max-width="600px">
        <v-stepper v-model="pag">
          <v-stepper-items>
            <v-stepper-content step="1">
              <v-card height="500px" class="show-text">
                <br />
                <v-card-title>
                  <h3 class="titleinf slot">{{formTitle}}</h3>
                </v-card-title>
                <br />
                <v-card-text class="show-text">
                  <div class="title-slot">
                    <h4>{{showedItem.code}} - {{showedItem.name}}</h4>
                    <div class="controls-slot">
                      <v-switch
                        v-model="showedItem.gbl_status_id"
                        color="success"
                        true-value="1"
                        false-value="0"
                        hide-details
                      ></v-switch>
                      <v-btn width="25" height="25" icon>
                        <v-icon medium>mdi-pencil</v-icon>
                      </v-btn>
                      <v-btn width="25" height="25" icon>
                        <v-icon medium>mdi-delete</v-icon>
                      </v-btn>
                    </div>
                  </div>
                  <p>
                    <br />
                    <b class="text-slot">Descripcion:</b>
                    {{showedItem.description}}
                    <br />
                  </p>
                  <br />
                  <br />
                  <v-divider></v-divider>
                  <br />
                  <br />
                  <v-btn
                    color="primary"
                    @click="openAdmission('Crear Punto de Admision',showedItem.id)"
                    dark
                  >Agregar punto de Admision</v-btn>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" @click="close" text>Regresar</v-btn>
                </v-card-actions>
              </v-card>
            </v-stepper-content>
            <v-stepper-content step="2">
              <v-card>
                <form action @submit="createAdmission(editedItem)">
                  <v-card-title>
                    <span class="headline">{{formTitle}}</span>
                  </v-card-title>

                  <v-card-text>
                    <v-container>
                      <v-col>
                        <v-row>
                          <v-text-field
                            v-model="editedItem.name"
                            label="Nombre *"
                            hint="Agrega un Nombre"
                          ></v-text-field>
                        </v-row>
                        <v-row>
                          <v-textarea
                            v-model="editedItem.description"
                            label="Descripciòn"
                            hint="Agrega una Descripciòn"
                          ></v-textarea>
                        </v-row>
                        <v-row>
                          <v-switch
                            v-model="editedItem.gbl_status_id"
                            true-value="1"
                            false-value="0"
                            color="success"
                            :label="`Estado: ${editedItem.gbl_status_id=='1'?'Activo':'No activo'}`"
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
                      @click.prevent="createAdmission(editedItem)"
                    >Guardar</v-btn>
                  </v-card-actions>
                </form>
              </v-card>
            </v-stepper-content>
          </v-stepper-items>
        </v-stepper>
      </v-dialog>
    </template>
    <!--  -->
  </v-card>
</template>



<script>
import { mapGetters } from "vuex";

export default {
  data: () => ({
    lang: {
      "footer-props": {
        "items-per-page-options": [5, 10, 20, -1],
        "items-per-page-text": "Resultado por pagina:",
        "items-per-page-all-text": "Todo",
        "page-text": "{0} - {1} de {2}"
      },
      "no-results-text": "No se encontraron resultados",
      "no-data-text": "No se encontraron datos"
    },

    keys: [
      { text: "Todos", value: null },
      { text: "Activo", value: "1" },
      { text: "No activo", value: "0" }
    ],
    headers: [
      { text: "", sortable: false, width: "10%" },
      { text: "", sortable: false, value: "gbl_status_id", width: "7%" },
      { text: "", sortable: false, value: "actions", width: "7%" },
      { text: "", sortable: false, value: "name", width: "25%" },
      {
        text: "",
        sortable: false,
        value: "data-table-expand",
        width: "50%px",
        align: "end"
      }
    ],
    headersAtt: [
      { text: "", sortable: false, width: "20%" },
      { text: "", sortable: false, value: "gbl_status_id", width: "7%" },
      { text: "", sortable: false, value: "actions", width: "7%" },
      { text: "", sortable: false, value: "name", width: "25%" },
      { text: "", sortable: false, width: "40%" }
    ],
    createEdit: false,
    show: false,
    filterSearch: "",
    filterState: null,
    erroresFormulario: [],
    editedItem: {},
    showedItem: {},
    deleteItem: {},
    formTitle: "",
    pag: 0
  }),

  mounted() {
    this.$store.dispatch("fetchOrgStructure");
  },

  methods: {
    openSede(title, item) {
      this.editedItem = {
        id: item ? item.id : -1,
        code: item ? item.code : "",
        name: item ? item.name : "",
        description: item ? item.description : "",
        gbl_status_id: item ? item.gbl_status_id : "1",
        lang: item ? item.lang : "es_CO",
        admission: item ? item.admission : []
      };
      this.formTitle = title;
      this.createEdit = true;
    },
    createSede(item) {
      this.erroresFormulario = [];
      if (item.id == -1) {
        this.$store.dispatch("createOrgStructure", item).then(data => {
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
        this.$store.dispatch("editOrgStructure", item).then(data => {
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

    openAdmission(title, idSede, item) {
      this.editedItem = {
        idsede: idSede,
        id: item ? item.id : -1,
        name: item ? item.name : "",
        description: item ? item.description : "",
        gbl_status_id: item ? item.gbl_status_id : "1",
        lang: item ? item.lang : "es_CO",
        attention: item ? item.attention : []
      };
      this.formTitle = title;
      this.pag = 2;
      this.show = true;
    },
    createAdmission(item){},
    showItem(title, item) {
      this.pag = 1;
      this.showedItem = item;
      this.formTitle = title;
      this.show = true;
    },
    close() {
      this.createEdit = false;
      this.show = false; 
      this.pag = 0;
    }
  },

  computed: {
    ...mapGetters(["orgStructure"])
  }
};
</script>
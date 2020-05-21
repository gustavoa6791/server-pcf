<template >
  <v-card class="elevation-10 slot conteiner">
    <v-card-title>
      <h1 class="titleinf slot">Tipos de consulta</h1>
      <v-btn :to="{ name: 'slottype' }" x-small>
        <v-icon small>mdi-arrow-left-bold</v-icon>Regresar
      </v-btn>
    </v-card-title>

    <v-card-text class="slot">
      <div class="title-slot">
        <h4>{{slotTypesDetails['description']}}</h4>
        <div class="controls-slot">
          <v-switch
            v-model="slotTypesDetails['gbl_status_id']"
            @change=" editSLotType(slotTypesDetails)"
            color="success"
            true-value="1"
            false-value="0"
            hide-details
          ></v-switch>
          <v-btn width="25" height="25" icon>
            <v-icon medium @click="open( slotTypesDetails )">mdi-pencil</v-icon>
          </v-btn>
          <v-btn width="25" height="25" icon>
            <v-icon medium @click="openDelete(slotTypesDetails)">mdi-delete</v-icon>
          </v-btn>

          <v-btn width="25" height="25" icon>
            <v-icon medium>mdi-shield</v-icon>
          </v-btn>
        </div>
      </div>
      <p>
        <br />
        <b class="text-slot">Codigo:</b>
        {{slotTypesDetails['code']}}
        <br />
        <b class="text-slot">Duracion(Min):</b>
        {{slotTypesDetails['duration_default']}}
        <br />
        <b class="text-slot">Numero de pacientes por turno:</b>
        {{slotTypesDetails['max_assign_allow']}}
      </p>
    </v-card-text>
    <v-divider />

    <br />
    <v-card-text class="slot">
      <div class="title-slot">
        <h6>Datos Adicionales</h6>
      </div>
      <p>
        <br />
        <b class="text-slot">Asegurador:</b>
        {{slotTypesDetails['entity_name']['entity_name']}}
        <br />
        <b class="text-slot">Plan de Atencion:</b>
        {{slotTypesDetails["plan_name"]["plan_name"]}}
        <br />
        <b class="text-slot">Tiempo Limite de Espera (Min):</b>
        {{slotTypesDetails['limit_attention']}}
        <br />
        <b class="text-slot">Mensaje / Recomendaciones:</b>
        {{slotTypesDetails['reminder_email']}}
      </p>
    </v-card-text>
    <v-divider />

    <br />
    <v-card-text class="slot">
      <div class="title-slot">
        <h6>Tipos de Atencion</h6>
        <div class="controls-slot">
          <v-btn width="25" height="25" icon>
            <v-icon @click="openAttention(null,'Crear Tipo de Atenciòn')" medium>mdi-plus-thick</v-icon>
          </v-btn>
        </div>
      </div>

      <div v-for="attention in attentionTypes" :key="attention.id">
        <div class="p-slot">
          <b class="text-slot">{{attention.description}}</b>
          <div class="controls-slot type">
            <v-switch
              v-model="attention.gbl_status_id"
              class="sw-slot"
              color="success"
              true-value="1"
              false-value="0"
              hide-details
              @change="createAttention(attention)"
            ></v-switch>
            <v-btn
              @click="openAttention(attention,'Editar Tipo de Atenciòn')"
              width="25"
              height="25"
              icon
            >
              <v-icon medium>mdi-pencil</v-icon>
            </v-btn>
            <v-btn @click="openDeleteAttention(attention)" width="25" height="25" icon>
              <v-icon medium>mdi-delete</v-icon>
            </v-btn>
          </div>
        </div>

        <p class="text-slot pro">{{attention.information_text}}</p>
        <p class="text-slot pro">
          <b>Plantilla:</b>
          {{attention.template.id}} - {{attention.template.title}}
        </p>

        <table class="text-slot table-slot">
          <thead>
            <tr>
              <td>
                <b>Servicios</b>
                <v-btn right width="20" height="20" x-small fab dark color="deep-purple accent-3">
                  <v-icon @click="openService(attention.id)" dark>mdi-plus</v-icon>
                </v-btn>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr v-for=" service in attention.services" :key="service.id">
              <div class="btn-table">
                <v-btn
                  @click="openDeleteService(service,attention.id)"
                  right
                  width="20"
                  height="20"
                  x-small
                  fab
                  dark
                  color="red"
                >
                  <v-icon dark>mdi-minus</v-icon>
                </v-btn>
              </div>

              <p class="p-table">
                <span>{{service.code}} - {{service.description}}</span>
              </p>
            </tr>
          </tbody>
        </table>
      </div>
    </v-card-text>
    <br />
    <v-divider />
    <!-- 
    <br />
    <v-card-text class="slot">
      <div class="title-slot">
        <h6>Asociacion de Profesiones</h6>
      </div>
      <br />
      <table class="text-slot table-slot">
        <thead>
          <tr>
            <td>
              <b>Profesiones</b>
              <v-btn right width="20" height="20" x-small fab dark color="deep-purple accent-3">
                <v-icon dark>mdi-plus</v-icon>
              </v-btn>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <span>555555 - este es un ejemplo de Profesiones</span>
              <v-btn right width="20" height="20" x-small fab dark color="red">
                <v-icon dark>mdi-minus</v-icon>
              </v-btn>
            </td>
          </tr>
        </tbody>
      </table>
    
    
    
    </v-card-text>
    -->
    <v-card-title>
      <h1></h1>
      <v-btn :to="{ name: 'slottype' }" x-small>
        <v-icon small>mdi-arrow-left-bold</v-icon>Regresar
      </v-btn>
    </v-card-title>

    <template class="modal-createEdit">
      <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card>
          <form @submit="editSlotType(editedItem)">
            <v-card-text>
              <div class="encabezado">
                <span class="headline">Editar Tipo de Consulta</span>
              </div>

              <v-row>
                <v-col>
                  <v-text-field
                    :error-messages="codeErrors"
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
                    v-model="editedItem.duration_default"
                    label="Duracion(Min) *"
                    hint="Agrega una duracion"
                    outlined
                    dense
                  ></v-text-field>
                </v-col>
                <v-col>
                  <v-text-field
                    :error-messages="max_assign_allowErrors"
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
                  color="success"
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
                  <v-autocomplete
                    v-bind="lang"
                    @change="selectPlan"
                    v-model="editedItem.entity_name"
                    :items="itemsAsegurador"
                    item-text="entity_name"
                    item-value="id"
                    hint="Agrega un asegurador"
                    label="Asegurador *"
                    return-object
                    dense
                    outlined
                  ></v-autocomplete>
                </v-col>
                <v-col>
                  <v-autocomplete
                    v-bind="lang"
                    v-model="editedItem.plan_name"
                    :items="itemsPlanFilter"
                    item-text="plan_name"
                    item-value="id"
                    hint="Agrega un Plan de Atencion"
                    label="Plan de Atencion"
                    return-object
                    dense
                    outlined
                    :disabled="planInput"
                  ></v-autocomplete>
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
              <v-btn color="blue darken-1" text @click.prevent="editSlotType(editedItem)">Agregar</v-btn>
            </v-card-actions>
          </form>
        </v-card>
      </v-dialog>
    </template>

    <template class="modal-deleteAttention">
      <v-dialog v-model="alertDeleteAttention" persistent max-width="400px">
        <v-card>
          <v-card-title>
            <span class="headline">Borrar?</span>
          </v-card-title>

          <div class="ver">
            <v-card-text>Estas seguro de borrar este tipo de Atenciòn</v-card-text>
          </div>

          <div class="ver">
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">Cancelar</v-btn>
              <v-btn color="blue darken-1" text @click="deleteAttentionType(deleteItem)">Borrar</v-btn>
            </v-card-actions>
          </div>
        </v-card>
      </v-dialog>
    </template>

    <!-- modal -->
    <template class="modal-createAttention">
      <v-dialog v-model="AttentionForm" persistent max-width="800px">
        <v-stepper v-model="pag">
          <v-stepper-items>
            <v-stepper-content step="1">
              <v-card>
                <form action @submit="createAttention(editedItemAttention)">
                  <v-card-title>
                    <span class="headline">{{formTitle}}</span>
                  </v-card-title>
                  <v-card-text>
                    <v-container>
                      <v-col>
                        <v-row>
                          <v-text-field
                            :error-messages="descriptionErrors"
                            v-model="editedItemAttention.description"
                            label="Nombre *"
                            required
                          ></v-text-field>
                        </v-row>
                        <v-row>
                          <v-textarea
                            v-model="editedItemAttention.information_text"
                            label="Descripciòn *"
                            hint="Agrega una descripciòn"
                          ></v-textarea>
                        </v-row>
                        <v-row>
                          <v-switch
                            v-model="editedItemAttention.gbl_status_id"
                            true-value="1"
                            false-value="0"
                            :label="`Estado: ${editedItemAttention.gbl_status_id=='1'?'Activo':'No activo'}`"
                            color="success"
                          ></v-switch>
                        </v-row>
                        <v-row>
                          <v-select
                            v-model="editedItemAttention.template"
                            :items="selectItems"
          
                            label="Plantilla"
                            disabled
                          >

                          <template v-slot:selection="{ item }">
                              {{item.id}} - {{item.title}}
                          </template>
                          
                          
                          </v-select>
                          <v-btn @click="openTemplate" color="primary" dark>
                            <v-icon>mdi-pencil</v-icon>
                          </v-btn>
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
                      @click.prevent="createAttention(editedItemAttention)"
                    >Guardar</v-btn>
                  </v-card-actions>
                </form>
              </v-card>
            </v-stepper-content>
            <v-stepper-content step="2">
              <v-card>
                <v-card-title>
                  <span class="headline">Seleccion de Plantilla</span>
                </v-card-title>

                <v-data-table
                  v-bind="lang"
                  v-model="selectItems"
                  class="table-template"
                  :headers="headersTemplate"
                  :items="templates"
                  :items-per-page="5"
                  show-select
                  single-select
                >
                  <template v-slot:item.image="{ item }">
                    <div class="act">
                      <v-carousel width="100%" height="80px" hide-delimiters>
                        <v-carousel-item
                          v-for="(image,i) in item.images"
                          :key="i"
                          :src="image.picture"
                          reverse-transition="fade-transition"
                          transition="fade-transition"
                        ></v-carousel-item>
                      </v-carousel>
                    </div>
                  </template>

                  <template v-slot:item.actions="{ item }">
                    <v-btn medium icon @click="viewTemplate(item)">
                      <v-icon large>mdi-eye</v-icon>
                    </v-btn>
                  </template>
                </v-data-table>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="pag=1">Cancelar</v-btn>
                  <v-btn color="blue darken-1" text @click="selectTemplate">Guardar</v-btn>
                </v-card-actions>
              </v-card>
            </v-stepper-content>
            <v-stepper-content step="3">
              <v-card>
                <v-carousel hide-delimiters height="400">
                  <v-carousel-item
                    v-for="(image,i) in viewTemItem.images"
                    :key="i"
                    reverse-transition="fade-transition"
                    transition="fade-transition"
                  >
                    <img style="width:100%;padding-top:5%;" :src="image.picture" alt />
                  </v-carousel-item>
                </v-carousel>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="pag=2">Regresar</v-btn>
                </v-card-actions>
              </v-card>
            </v-stepper-content>
          </v-stepper-items>
        </v-stepper>
      </v-dialog>
    </template> 
    <!--  -->

    <!-- modal -->
    <template class="modal-selecService">
      <v-dialog v-model="serviceForm" persistent max-width="600px">
        <v-card>
          <v-card-title>
            <h1 class="titleinf">Servicios</h1>
            <div class="filters">
              <v-text-field
                v-model="filterSearch"
                append-icon="mdi-magnify"
                label="Buscar"
                single-line
                hide-details
              ></v-text-field>
            </div>
          </v-card-title>
          <v-data-table
            v-bind="lang"
            v-model="selectItems"
            :items="services"
            :items-per-page="5"
            show-select
            :headers="headersService"
            item-key="code"
            dense
          ></v-data-table>
          <template v-slot:no-data>
            <h5>No se encontraron datos</h5>
          </template>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="close">Cancelar</v-btn>
            <v-btn color="blue darken-1" text @click="updateService()">Guardar</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </template>
    <!--  -->

    <!-- modal -->
    <template class="modal-deleteService">
      <v-dialog v-model="alertDeleteService" persistent max-width="400px">
        <v-card>
          <v-card-title>
            <span class="headline">Borrar?</span>
          </v-card-title>

          <div class="ver">
            <v-card-text>Estas seguro de borrar este servicio</v-card-text>
          </div>

          <div class="ver">
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">Cancelar</v-btn>
              <v-btn color="blue darken-1" text @click="deleteService(deleteItem)">Borrar</v-btn>
            </v-card-actions>
          </div>
        </v-card>
      </v-dialog>
    </template>
    <!-- -->

    <!-- modal -->
    <template class="modal-delete">
      <v-dialog v-model="alertDelete" persistent max-width="400px">
        <v-card>
          <v-card-title>
            <span class="headline">Borrar?</span>
          </v-card-title>

          <div class="ver">
            <v-card-text>Estas seguro de borrar este tipo de Consulta</v-card-text>
          </div>

          <div class="ver">
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">Cancelar</v-btn>
              <v-btn color="blue darken-1" text @click="deleteSlotType(deleteItem)">Borrar</v-btn>
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
    lang: {
      "footer-props": {
        "items-per-page-options": [5, 10, 20, -1],
        "items-per-page-text": "Resultado por pagina:",
        "items-per-page-all-text": "Todo",
        "page-text": "{0}-{1} de {2}"
      },
      "no-results-text": "No se encontraron resultados",
      "no-data-text": "No se encontraron datos"
    },
    alertDelete: false,
    alertDeleteService: false,
    alertDeleteAttention: false,
    dialog: false,
    AttentionForm: false,
    serviceForm: false,
    planInput: true,
    editedItem: {},
    editedItemAttention: {},
    deleteItem: {},
    formTitle: "",
    filterSearch: "",
    erroresFormulario: [],
    selectItems: [],
    services: [],
    itemsAsegurador: [],
    itemsPlan: [],
    itemsPlanFilter: [],
    templates: [],
    pag: 1,
    viewTemItem: {}
  }),

  mounted() {},

  created() {
    this.$store.dispatch("findSlotType", this.$route.params.slot["id"]);
    this.$store
      .dispatch("findAttentionType", this.$route.params.slot["id"])
      .then(data => {
        this.attentions = data;
      });
  },

  methods: {
    filterSearchFunction(value) {
      if (!this.filterSearch) {
        return true;
      }
      return value.toLowerCase().includes(this.filterSearch.toLowerCase());
    },

    createAttention(at) {
      this.erroresFormulario = [];
      if (at.id == -1) {
        this.$store.dispatch("createAttentionType", at).then(data => {
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
        this.$store.dispatch("editAttentionType", at).then(data => {
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
    editSLotType(item) {
      this.editedItem = item;
      this.$store.dispatch("editSlotType", this.editedItem);
    },

    openDelete(item) {
      this.deleteItem = item;
      this.alertDelete = true;
    },

    deleteSlotType() {
      this.$store.dispatch("deleteSlotType", this.deleteItem);
      this.alertDelete = false;
      this.$router.push({ name: "slottype" });
    },

    open(item) {
      this.erroresFormulario = [];

      this.$store.dispatch("fetchPlanAsegurador").then(data => {
        this.itemsAsegurador = data.asegurador;
        this.itemsPlan = data.plan;
        this.itemsPlanFilter = data.plan;
      });
      this.editedItem = {
        id: item.id,
        code: item.code,
        description: item.description,
        duration_default: item.duration_default,
        max_assign_allow: item.max_assign_allow,
        gbl_status_id: item.gbl_status_id,
        entity_name: item.entity_name,
        plan_name: item.plan_name,
        limit_attention: item.limit_attention,
        reminder_email: item.reminder_email,
        lang: "es_CO"
      };
      this.dialog = true;
    },

    openAttention(item, title) {
      this.formTitle = title;
      this.selectItems = item ? [item.template]: []
      this.editedItemAttention = {
        id: item ? item.id : -1,
        idSlot: this.slotTypesDetails.id,
        description: item ? item.description : "",
        information_text: item ? item.information_text : "",
        gbl_status_id: item ? item.gbl_status_id : "1",
        lang: "es_CO",
        services: item ? item.services : [],
        template: item ? item.template : ""
      };

      this.AttentionForm = true;
    },
    openDeleteAttention(item) {
      this.deleteItem = item;
      this.alertDeleteAttention = true;
    },
    deleteAttentionType() {
      this.$store.dispatch("deleteAttentionType", this.deleteItem);
      this.close();
    },

    openService(idAtte) {
      this.editedItem = idAtte;
      this.$store.dispatch("fetchService").then(data => {
        this.services = data;
      });
      this.serviceForm = true;
    },
    openDeleteService(item, idatt) {
      this.deleteItem = item;
      this.deleteItem["idatt"] = idatt;
      this.alertDeleteService = true;
    },
    updateService() {
      this.$store.dispatch("updateService", [
        this.editedItem,
        this.selectItems
      ]);
      this.close();
    },
    deleteService(deleteItem) {
      this.$store.dispatch("deleteService", deleteItem);

      this.close();
    },

    editSlotType(item) {
      this.erroresFormulario = [];
      this.$store.dispatch("editSlotType", item).then(data => {
        if (data != undefined) {
          this.erroresFormulario = data;
        }
        if (this.erroresFormulario.length == 0) {
          this.close();
        } else {
          this.reopen(this.editedItem);
        }
      });
    },

    close() {
      this.dialog = false;
      this.AttentionForm = false;
      this.serviceForm = false;
      this.alertDelete = false;
      this.alertDeleteService = false;
      this.alertDeleteAttention = false;
      this.selectItems = [];
      this.services = [];
    },
    reopen(item) {
      this.editedItem = {
        id: item.id,
        code: item.code,
        description: item.description,
        duration_default: item.duration_default,
        max_assign_allow: item.max_assign_allow,
        gbl_status_id: item.gbl_status_id,
        entity_name: item.entity_name,
        plan_name: item.plan_name,
        limit_attention: item.limit_attention,
        reminder_email: item.reminder_email,
        lang: "es_CO"
      };
    },

    selectPlan() {
      this.itemsPlanFilter = this.itemsPlan.filter(
        plan =>
          plan["cnt_insurance_entity_id"] ==
          this.editedItem["entity_name"]["id"]
      );

      this.planInput = false;
    },

    openTemplate() {
      this.$store.dispatch("fetchTemplate").then(data => {
        this.templates = data;
      });
      this.pag = 2;
    },
    viewTemplate(item) {
      this.viewTemItem = item;

      this.pag = 3;
    },
    selectTemplate() {
      this.editedItemAttention.template = this.selectItems[0];
      this.pag = 1;
    }
  },

  computed: {
    ...mapGetters(["slotTypesDetails"]),
    ...mapGetters(["attentionTypes"]),
    headersService() {
      return [
        {
          text: "Codigo",
          align: "start",
          sortable: true,
          value: "code",
          width: "20%"
        },
        {
          text: "Nombre Servicio",
          align: "start",
          sortable: true,
          value: "description",
          width: "80%",
          filter: this.filterSearchFunction
        }
      ];
    },
    headersTemplate() {
      return [
        {
          text: "Grupo",
          align: "start",
          sortable: true,
          value: "name",
          width: "100px"
        },
        {
          text: "Plantilla",
          align: "start",
          sortable: true,
          value: "title",
          width: "100px"
        },
        {
          text: "Descripciòn",
          align: "start",
          sortable: false,
          value: "description",
          width: "100px"
        },
        {
          text: "imagen",
          align: "start",
          sortable: false,
          value: "image",
          width: "170px"
        },
        {
          text: "Acciones",
          align: "center",
          sortable: false,
          value: "actions",
          width: "60px"
        }
      ];
    },
    codeErrors() {
      var e = [];
      if (this.erroresFormulario.code != undefined) {
        var json = JSON.parse(JSON.stringify(this.erroresFormulario.code));
        json.forEach(element => {
          console.log(element);
          switch (element) {
            case "The code has already been taken.":
              e.push("El codigo ya existe");
              break;
            case "The code field is required.":
              e.push("El campo codigo es requerido");
              break;
            case "The code may not be greater than 50 characters.":
              e.push("El codigo no puede tener más de 50 caracteres.");
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
            case "The description has already been taken.":
              e.push("El nombre ya existe");
              break;
            case "The description field is required.":
              e.push("El campo nombre es requerido");
              break;
            case "The description may not be greater than 255 characters.":
              e.push("El nombre no puede tener más de 255 caracteres.");
              break;
            default:
              e.push("ha ocurrido un error");
              break;
          }
        });
      }
      return e;
    },
    max_assign_allowErrors() {
      var e = [];
      if (this.erroresFormulario.max_assign_allow != undefined) {
        var json = JSON.parse(
          JSON.stringify(this.erroresFormulario.max_assign_allow)
        );
        json.forEach(element => {
          console.log(element);
          switch (element) {
            case "The max assign allow field is required.":
              e.push("El campo Numero de Pacientes es requerido");
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
<template >
  <v-card class="elevation-10 slot conteiner">
    <v-card-title>
      <h1 class="titleinf slot">Tipos de consulta</h1>
    </v-card-title>

    <v-card-text class="slot">
      <div class="title-slot">
        <h4>{{item['description']}}</h4>
        <div>
          <v-icon medium>mdi-pencil</v-icon>
          <v-icon medium>mdi-shield</v-icon>
        </div>
      </div>
      <p>
        <br />
        <b class="text-slot">Codigo:&nbsp;</b>
        {{item['code']}}
        <br />
        <b class="text-slot">Duracion(Min):&nbsp;</b>
        {{item['duration_default']}}
        <br />
        <b class="text-slot">Numero de pacientes por turno:&nbsp;</b>
        {{item['max_assign_allow']}}
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
        <b class="text-slot">Asegurador:&nbsp;</b>
        {{item['code']}}
        <br />
        <b class="text-slot">Plan de Atencion:&nbsp;</b>
        {{item['duration_default']}}
        <br />
        <b class="text-slot">Tiempo Limite de Espera (Min):&nbsp;</b>
        {{item['max_assign_allow']}}
        <br />
        <b class="text-slot">Mensaje / Recomendaciones:&nbsp;</b>
        {{item['max_assign_allow']}}
      </p>
    </v-card-text>
    <v-divider />

    <br />
    <v-card-text class="slot">
      <div class="title-slot">
        <h6>Tipos de Atencion</h6>
        <div>
          <v-icon medium>mdi-pencil</v-icon>
          <v-icon medium>mdi-plus-thick</v-icon>
        </div>
      </div>
     
      <div class="p-slot">
        <b class="text-slot">Procedimiento:&nbsp;</b>
        <v-switch class="sw-slot" color="success" true-value="1" false-value="0" hide-details></v-switch>
      </div>

      <p class="text-slot pro">
        Lorem ipsum dolor sit amet consectetur adipisicing elit.
        Quibusdam fugit error repellat quo officia, quisquam voluptatum!
        Sed ratione, aperiam, cupiditate iure vel consectetur ducimus
        veritatis quae tenetur facere numquam rerum!
      </p>
      <table class="text-slot table-slot">
        <thead>
          <tr>
            <td>
              <b>Servicios</b>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>555555- este es un ejemplo de servicio</td>
          </tr>
          <tr>
            <td>555555- este es un ejemplo de servicio</td>
          </tr>
        </tbody>
      </table>
    </v-card-text>
    <br />
    <v-divider />

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
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>555555- este es un ejemplo de Profesiones</td>
          </tr>
          <tr>
            <td>555555- este es un ejemplo de Profesiones</td>
          </tr>
        </tbody>
      </table>
    </v-card-text>
    <br />
    <br />

    <!--    
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
                  <v-text-field
                    
                    label="Asegurador *"
                    hint="Agrega un asegurador"
                    outlined
                    dense
                  ></v-text-field>
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

    -->
  </v-card>
</template>



<script>
import { mapGetters } from "vuex";

export default {
  data: () => ({
    alertDelete: false,
    dialog: false,
    item: {}
  }),

  mounted() {},

  created() {
    this.$store
      .dispatch("findSlotType", this.$route.params.slot["id"])
      .then(data => {
        this.item = data[0];
      });
  },

  methods: {},

  computed: {
    ...mapGetters(["slotTypesDetails"])
  }
};
</script>
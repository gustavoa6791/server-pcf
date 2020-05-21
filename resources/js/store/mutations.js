let mutations = {
    CREATE_PROFILE_TYPE(state, pt) {
        state.profileTypes.unshift(pt)
    },
    FETCH_PROFILE_TYPE(state, pt) {
        return state.profileTypes = pt
    },
    SEARCH_PROFILE_TYPE(state, pt) {
        return state.profileTypes = pt
    },
    DELETE_PROFILE_TYPE(state, pt) {
        let index = state.profileTypes.findIndex(item => item.id === pt.id)
        state.profileTypes.splice(index, 1)
    },
    EDIT_PROFILE_TYPE(state, pt){
        let index = state.profileTypes.findIndex(item => item.id === pt.id)
        state.profileTypes.splice(index, 1, pt)
    },


    CREATE_SLOT_TYPE(state, st) {
        state.slotTypes.unshift(st)
    },
    FETCH_SLOT_TYPE(state, st) {
        return state.slotTypes = st
    },
    FIND_SLOT_TYPE(state, st) {
        return state.slotTypesDetails = st[0]
    },
    DELETE_SLOT_TYPE(state, st) {
        let index = state.slotTypes.findIndex(item => item.id === st.id)
        state.slotTypes.splice(index, 1)
    },
    EDIT_SLOT_TYPE(state, st){
        state.slotTypesDetails = st
    },

    
    CREATE_ATTENTION_TYPE(state, st) {
        state.attentionTypes.unshift(st)
    },
    FIND_ATTENTION_TYPE(state, st) {
        return state.attentionTypes = st
    },
    DELETE_ATTENTION_TYPE(state, at){
        let index = state.attentionTypes.findIndex(item => item.id === at.id)
        state.attentionTypes.splice(index, 1)

    },
    EDIT_ATTENTION_TYPE(state, at){
        let index = state.attentionTypes.findIndex(item => item.id === at.id)
        state.attentionTypes.splice(index, 1, at)
    },

    UPDATE_SERVICE(state, sv){
        let index = state.attentionTypes.findIndex(item => item.id == sv[0])
        sv[1].forEach(element => {
            state.attentionTypes[index]['services'].push( element)
        });
    },
    DELETE_SERVICE(state, sv) {
        let index = state.attentionTypes.findIndex(item => item.id === sv.idatt)
        let indexSV = state.attentionTypes[index]['services'].findIndex(item => item.id === sv.id)
        state.attentionTypes[index]['services'].splice(indexSV, 1)
    },

    FETCH_ORG_STRUCTURE(state, os) {
        return state.orgStructure = os
    },
    CREATE_ORG_STRUCTURE(state, os) {
        state.orgStructure.unshift(os)
    },
    EDIT_ORG_STRUCTURE(state, os){
        let index = state.orgStructure.findIndex(item => item.id === os.id)
        state.orgStructure.splice(index, 1, os)
    },


}
export default mutations
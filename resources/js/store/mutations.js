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
        return state.slotTypesDetails = st
    },
    SEARCH_SLOT_TYPE(state, st) {
        return state.slotTypes = st
    },
    DELETE_SLOT_TYPE(state, st) {
        let index = state.slotTypes.findIndex(item => item.id === st.id)
        state.slotTypes.splice(index, 1)
    },
    EDIT_SLOT_TYPE(state, st){
        let index = state.slotTypes.findIndex(item => item.id === st.id)
        state.slotTypes.splice(index, 1, st)
    }

}
export default mutations
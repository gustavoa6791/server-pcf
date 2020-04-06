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
    }

}
export default mutations
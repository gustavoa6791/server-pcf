import Vue from 'vue'
import Router from 'vue-router'
import ProfileTypePage from './views/ProfileTypePage.vue'
import SlotTypePage from './views/SlotTypePage.vue'
import SlotTypeDetailsPage from './views/SlotTypeDetailsPage.vue'


Vue.use(Router)

export default new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/profileType',
            name: 'profiletype',
            component: ProfileTypePage
        },
        {
            path: '/slotType',
            name: 'slottype',
            component: SlotTypePage
        },
        {
            path: '/slotTypeDetails',
            name: 'slottypedetails',
            component: SlotTypeDetailsPage
        },
    ]
})
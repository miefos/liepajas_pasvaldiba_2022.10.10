import { createStore } from 'vuex';
import axios from "axios";
import Cookies from "js-cookie";
import {Inertia} from "@inertiajs/inertia";

export default createStore({
    state: {
        // selectedEntity: null,
        // entities: null,
        // errorNoEntityAvailable: false
    },
    actions: {
        // updateListOfAvailableEntities({ commit, rootState, dispatch, state }, entities) {
        //     state.entities = entities
        // },
        // getFirstAvailableEntity({ commit, rootState, dispatch, state }) {
        //     console.log(state.entities.length )
        //     if (!state.selectedEntity) {
        //         if (state.entities.length > 0) {
        //             commit('updateEntity', state.entities[0])
        //         } else {
        //             commit('errorNoEntityAvailable')
        //         }
        //     }
        // },
        // selectEntity({ commit, rootState, dispatch, state }, entity) {
        //     if (state.entities.includes(entity)) {
        //         console.log('updated entity')
        //         commit('updateEntity', entity)
        //     } else {
        //         commit('errorNoEntityAvailable')
        //     }
        // },
    },
    getters: {
        // selectedEntity (state) {
        //     return state.selectedEntity
        // },
        // errorNoEntityAvailable (state) {
        //     return state.errorNoEntityAvailable
        // }
    },
    mutations: {
        // updateEntity(state, entity) {
        //     Cookies.set('entity', entity?.id ?? 0)
        //     state.selectedEntity = entity
        //     Inertia.reload({only: [
        //         'accounts',
        //         'transactions',
        //         'counterparties',
        //         'currencies',
        //         'listings',
        //         'transactionLines',
        //     ]})
        // },
        // errorNoEntityAvailable(state) {
        //     state.errorNoEntityAvailable = true
        //     location.reload()
        // }
    },
})

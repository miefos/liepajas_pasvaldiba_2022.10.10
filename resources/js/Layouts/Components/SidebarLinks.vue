<template>
    <template v-for="item in links" :key="item.name" >
        <template v-if="hasPermission(item)">
            <!--

            Link without children

             -->
            <template v-if="!haveChildren(item)">
                <a  v-if="typeof item.notInertiaLink === 'boolean' && item.notInertiaLink"
                    :href="item.href"
                    :class="[
               (route().current() === item.routeName && paramsMatch(item))  ? // active
               'bg-custom-main-900 text-white' :
               'text-white hover:bg-custom-main-800',
               // 'text-cyan-100 hover:text-white hover:bg-cyan-600',
               'transition duration-300 group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md'
               ]"
                    :aria-current="item.current ? 'page' : undefined">
                    <component :is="item.icon" class="mr-4 flex-shrink-0 h-6 w-6 text-white" aria-hidden="true" />
                    <span class="flex-1">
                {{ item.name }}
            </span>
                    <span v-if="$page.props[item.badge]" class="bg-red-400 ml-3 inline-block py-0.5 px-3 text-xs font-medium rounded-full">
                {{ $page.props[item.badge] }}
            </span>
                </a>

                <Link v-else
                      :href="item.routeName === '#' ? '#' : route(item.routeName, item.params)"
                      :class="[
                                       (route().current() === item.routeName && paramsMatch(item))  ? // active
                                       'bg-custom-main-900 text-white' :
                                       'text-white hover:bg-custom-main-800',
                                       // 'text-cyan-100 hover:text-white hover:bg-cyan-600',
                                       'transition duration-300 group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md'
                                       ]"
                      :aria-current="item.current ? 'page' : undefined">
                    <component :is="item.icon" class="mr-4 flex-shrink-0 h-6 w-6 text-white" aria-hidden="true" />
                    <span class="flex-1">
                {{ item.name }}
            </span>
                    <span v-if="$page.props[item.badge]" class="bg-red-400 ml-3 inline-block py-0.5 px-3 text-xs font-medium rounded-full">
                {{ $page.props[item.badge] }}
            </span>
                </Link>
            </template>


            <!--

            Link with children

            -->
            <Disclosure
                v-else
                as="div"
                class="space-y-1"
                v-slot="{ open }"
                :defaultOpen="isAnyChildRoute(item)"
            >
                <DisclosureButton
                    :class="[
                       route().current() === item.routeName  ? // active
                       'bg-custom-main-900 text-white' :
                       'text-white hover:bg-custom-main-800',
                       // 'text-cyan-100 hover:text-white hover:bg-cyan-600',
                       'w-full text-left transition duration-300 group flex px-2 py-2 text-sm leading-6 font-medium rounded-md'
                       ]"
                >
                    <component :is="item.icon" class="mr-4 flex-shrink-0 h-6 w-6 text-white" aria-hidden="true" />
                    <span class="flex-1">
                    {{ item.name }}
                  </span>
                    <svg :class="[open ? '-rotate-90' : 'rotate-90', 'ml-3 flex-shrink-0 h-5 w-5 transform transition-colors ease-in-out duration-300']" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M6 6L14 10L6 14V6Z" fill="currentColor" />
                    </svg>
                </DisclosureButton>
                <DisclosurePanel class="space-y-1">
                    <template
                        v-for="subItem in item.children"
                        :key="subItem.name"
                    >
                        <template v-if="typeof(subItem.can) === 'undefined' || subItem.can.length < 1 || hasAnyPermission(subItem.can)">
                            <Link
                                :href="subItem.routeName === '#' ? '#' : route(subItem.routeName)"
                                :class="[
                               route().current() === subItem.routeName ? // active
                               'bg-custom-main-900 text-white' :
                               'text-white hover:bg-custom-main-800',
                               // 'text-cyan-100 hover:text-white hover:bg-cyan-600',
                               'w-full pl-8 pr-2 py-2 transition duration-300 group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md'
                               ]"
                            >
                                <component :is="subItem.icon" class="mr-3 flex-shrink-0 h-5 w-5 text-white" aria-hidden="true" />
                                {{ subItem.name }}
                            </Link>
                        </template>
                    </template>
                </DisclosurePanel>
            </Disclosure>
        </template>
    </template>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
export default {
    name: "SidebarLinks",
    props: {
        links: Array
    },
    components: {Link, Disclosure, DisclosurePanel, DisclosureButton},
    methods: {
        paramsMatch(item) { // checks if query params match current route?
            if (typeof item.params === "undefined") return true
            const paramKeys = Object.keys(item.params)
            const currentParams = this.route().params
            for (let i = 0; i < paramKeys.length; i++) {
                const paramKey = paramKeys[i]
                if (typeof currentParams[paramKey] === "undefined" || item.params[paramKey] !== currentParams[paramKey])
                    return false
            }
            return true;
        },
        isAnyChildRoute(item) { // check if any of the children links is active (opened)
            if (!this.haveChildren(item)) return false
            const children = item.children
            const n = children.length
            const currentRoute = this.route().current()

            for (let i = 0; i < n; i++) {
                if (children[i].routeName === currentRoute) return true;
            }

            return false;
        },
        hasAnyChildrenPermission(item) {
            if (!this.haveChildren(item)) return false
            const children = item.children
            const n = children.length

            for (let i = 0; i < n; i++) {
                if (this.hasPermissionsSet(children[i]) && this.hasAnyPermission(children[i].can))
                    return true;
            }

            return false;
        },
        haveChildren(item) {
            return typeof(item.children) !== 'undefined' && Array.isArray(item.children) && item.children.length > 0
        },
        hasPermissionsSet(item) { // check if is set "can" attribute
            return typeof(item.can) !== 'undefined' && Array.isArray(item.can) && item.can.length > 0
        },
        hasPermission(item) {
            if (this.haveChildren(item)) {
                return this.hasAnyChildrenPermission(item)
            } else {
                if (this.hasPermissionsSet(item)) {
                    return this.hasAnyPermission(item.can)
                } else {
                    return true;
                }
            }
        }
    }
}
</script>

<style scoped>
</style>

<template>
    <div>
        <Head :title="title" />

        <jet-banner />

        <div class="site-container">
            <header class="site-sidebar">
                <div class="site-sidebar__sticky">
                    <div class="site-sidebar__main">
                        <h1 class="site-logo">
                            <a :href="route('dashboard')">
                                <img src="../../images/logo.svg">
                            </a>
                        </h1>
                        <nav class="site-nav">
                            <ul>
                                <li class="site-nav__item">
                                    <a :href="route('dashboard')" class="site-nav__link" :class="{'is-active': route().current('dashboard')}">
                                        <span class="site-nav__icon">
                                            <Icon icon="dashboard" />
                                        </span>
                                        Dashboard
                                    </a>
                                </li>
                                <li class="site-nav__item">
                                    <a :href="route('dashboard')" class="site-nav__link">
                                        <span class="site-nav__icon">
                                            <Icon icon="schedule" />
                                        </span>
                                        Schedule
                                    </a>
                                </li>
                                <li class="site-nav__item">
                                    <a :href="route('dashboard')" class="site-nav__link">
                                        <span class="site-nav__icon">
                                            <Icon icon="calendar" />
                                        </span>
                                        Calendar
                                    </a>
                                </li>
                                <li class="site-nav__item">
                                    <a :href="route('dashboard')" class="site-nav__link">
                                        <span class="site-nav__icon">
                                            <Icon icon="person" />
                                        </span>
                                        KEEs
                                    </a>
                                </li>
                                <li class="site-nav__item">
                                    <a :href="route('dashboard')" class="site-nav__link">
                                        <span class="site-nav__icon">
                                            <Icon icon="manage" />
                                        </span>
                                        Manage
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <div class="site-sidebar__user">
                            <div class="site-sidebar__user-profile">
                                <span class="site-sidebar__user-status site-sidebar__user-status--online"></span>
                                <a :href="route('profile.show')" class="profile-link">
                                    <img class="site-sidebar__user-image" src="../../images/placeholder-profile.jpg">
                                </a>
                            </div>
                            <div>
                                <a :href="route('profile.show')" class="site-sidebar__user-link">
                                    John Smith
                                </a>
                            </div>
                            <form @submit.prevent="logout">
                                <button type="submit" class="link">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="site-sidebar__secondary">
                        <div class="site-sidebar__secondary-icon">
                            <Icon icon="manage" />
                        </div>
                        <nav class="site-sidebar__secondary-nav">
                            <ul>
                                <li class="site-sidebar__secondary-item">
                                    <a :href="route('role.index')" class="site-sidebar__secondary-link">
                                        <div class="site-sidebar__secondary-link-icon">
                                            <Icon icon="star" />
                                        </div>
                                        Roles
                                    </a>
                                </li>
                                <li class="site-sidebar__secondary-item">
                                    <a :href="route('permission.index')" class="site-sidebar__secondary-link">
                                        <div class="site-sidebar__secondary-link-icon">
                                            <Icon icon="lock" />
                                        </div>
                                        Permissions
                                    </a>
                                </li>
                                <li class="site-sidebar__secondary-item">
                                    <a :href="route('user.index')" class="site-sidebar__secondary-link">
                                        <div class="site-sidebar__secondary-link-icon">
                                            <Icon icon="person" />
                                        </div>
                                        Users
                                    </a>
                                </li>
                                <li class="site-sidebar__secondary-item">
                                    <a :href="route('kee.index')" class="site-sidebar__secondary-link">
                                        <div class="site-sidebar__secondary-link-icon">
                                            <Icon icon="person" />
                                        </div>
                                        KEEs
                                    </a>
                                </li>
                                <li class="site-sidebar__secondary-item">
                                    <a :href="route('engagement.create')" class="site-sidebar__secondary-link">
                                        <div class="site-sidebar__secondary-link-icon">
                                            <Icon icon="location" />
                                        </div>
                                        Engagements
                                    </a>
                                </li>
                                <li class="site-sidebar__secondary-item">
                                    <a href="#" class="site-sidebar__secondary-link">
                                        <div class="site-sidebar__secondary-link-icon">
                                            <Icon icon="sliders" />
                                        </div>
                                        Evaluate
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="site-sidebar__secondary" v-if="route().current('kee-ranking')">
                        <div class="site-sidebar__secondary-icon">
                            <Icon icon="person" />
                        </div>
                        <nav class="site-sidebar__secondary-nav">
                            <ul>
                                <li class="site-sidebar__secondary-item site-sidebar__secondary-item--padding site-sidebar__secondary-item--margin">
                                    <select class="select-white">
                                        <option>
                                            Ranking
                                        </option>
                                    </select>
                                    <select class="select-white">
                                        <option>
                                            Commitment
                                        </option>
                                    </select>
                                    <select class="select-white">
                                        <option>
                                            Performance
                                        </option>
                                    </select>
                                    <select class="select-white">
                                        <option>
                                            Specialism
                                        </option>
                                    </select>
                                    <select class="select-white">
                                        <option>
                                            Country
                                        </option>
                                    </select>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </header>
            <div class="site-main">
                <div class="notifications-header">
                    <a href="#" class="notifications-header__link">
                        <span class="notifications-header__icon">
                            <span class="notification-header__alert"></span>
                            <Icon icon="bell" />
                        </span>
                        Notifications
                    </a>
                </div>
                <div class="site-main__wrapper">
                    <div class="site-main__header">
                        <slot name="header"></slot>
                    </div>
                    <slot></slot>
                </div>
            </div>
        </div>
        <footer class="site-footer">
            <img class="site-footer__logo" src="../../images/astrazeneca-logo.svg">
        </footer>
    </div>
</template>

<script>
    import JetApplicationMark from '@/Jetstream/ApplicationMark.vue'
    import JetBanner from '@/Jetstream/Banner.vue'
    import JetDropdown from '@/Jetstream/Dropdown.vue'
    import JetDropdownLink from '@/Jetstream/DropdownLink.vue'
    import JetNavLink from '@/Jetstream/NavLink.vue'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Icon from '@/Components/Icons.vue';

    export default {
        props: {
            title: String,
        },

        components: {
            Head,
            JetApplicationMark,
            JetBanner,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
            Link,
            Icon,
        },

        data() {
            return {
                showingNavigationDropdown: false
            }
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                this.$inertia.post(route('logout'));
            },
        }
    }
</script>

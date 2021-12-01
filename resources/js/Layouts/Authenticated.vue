<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-light bg-white border-bottom sticky-top">
      <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="/">
          <inertia-link :href="route('dashboard')">
            <breeze-application-logo width="36" />
          </inertia-link>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav mr-auto">
            <breeze-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
              Dashboard
            </breeze-nav-link>
          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto align-items-baseline">
            <!-- Authentication Links -->
            <breeze-dropdown id="settingsDropdown">
              <template #trigger>
<!--                <span v-if="$page.props.auth">
                   {{ $page.props.auth.user.firstname }}
                </span>-->


              </template>

              <template #content>
                <!-- Authentication -->
                <breeze-dropdown-link :href="route('logout')" method="post">
                  Log Out
                </breeze-dropdown-link>
              </template>
            </breeze-dropdown>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Heading -->
    <header class="d-flex py-3 bg-white shadow-sm border-bottom">
      <div class="container">
        <slot name="header" />
      </div>
    </header>

    <!-- Page Content -->
    <main class="container my-5">
      <slot />
    </main>
  </div>
</template>

<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo'
import BreezeDropdown from '@/Components/Dropdown'
import BreezeDropdownLink from '@/Components/DropdownLink'
import BreezeNavLink from '@/Components/NavLink'

export default {
  components: {
    BreezeApplicationLogo,
    BreezeDropdown,
    BreezeDropdownLink,
    BreezeNavLink
  },

  data() {
    return {
      showingNavigationDropdown: false,
    }
  },
}
</script>

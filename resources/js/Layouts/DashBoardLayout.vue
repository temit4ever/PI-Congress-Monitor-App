<template>
  <html lang="en">
  <head>
    <title>Dashboard</title>
  </head>
  <body class="sidebar-mini" style="height: auto;">
  <div class="wrapper" id="app">
  <NavBarLayout />
  <SideBarLayout />

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v2</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
          <div class="col-lg-12">
            <DashboardContentLayout />
          </div>
        </div><!-- /.container-fluid -->
      </div><!-- Main content -->
      <!-- /.content-wrapper -->
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
            </div>
          </div>
        </div>
      </section>
    </div>
    <Footer />
  </div>
  <!-- ./wrapper -->
  </body>
  </html>
</template>

<script>
import Footer from "@/Pages/Footer";
import NavBarLayout from "@/Layouts/NavBarLayout";
import SideBarLayout from "./SideBarLayout";
import DashboardContentLayout from "./DashboardContentLayout";
export default {
  name: "DashboardLayout.vue",
  components: {
    NavBarLayout,
    Footer,
    SideBarLayout,
    DashboardContentLayout,
  }
}
</script>

<style scoped>

</style>

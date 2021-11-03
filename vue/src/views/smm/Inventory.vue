<template>
  <div class="wrapper">
  <CRow>
    <CCol col="12" xl="12">
      <transition name="slide">
      <CCard>
        <CCardHeader>
            Inventory
        </CCardHeader>
        <CCardBody>
          <CButton color="primary" class="mb-2" @click="modalCreate = true">Buat Permintaan Baru</CButton>
          <CButton color="light" class="mb-2 float-right" @click="reload()"><CIcon :content="$options.freeSet.cilReload"/></CButton>
          <CAlert
            :show.sync="dismissCountDown"
            color="info"
            fade
          >
            ({{dismissCountDown}}) {{ message }}
          </CAlert>
          <CDataTable
            hover
            striped
            :items="items"
            :fields="fields"
            :items-per-page="10"
            pagination
          >
          <template #action="{item}">
            <td>
              <CButton color="success" size="sm" class="mr-2" @click="editRow( item.id )">Edit</CButton>
              <CButton color="danger" size="sm" @click="deleteRow( item.id )">Delete</CButton>
            </td>
          </template>
        </CDataTable>
        </CCardBody>
      </CCard>
      </transition>
    </CCol>
  </CRow>

    <CModal
      :show.sync="modalCreate"
      :no-close-on-backdrop="true"
      :centered="true"
      title="Tambah Permintaan Barang"
      size="lg"
      color="dark"
    >
      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
      <template #header>
        <h6 class="modal-title">Tambah Permintaan Barang</h6>
        <CButtonClose @click="modalCreate = false" class="text-white"/>
      </template>
      <template #footer>
        <CButton @click="modalCreate = false" color="secondary">Batal</CButton>
        <CButton @click="modalCreate = false" color="primary">Proses</CButton>
      </template>
    </CModal>
    </div>
</template>

<script>
import { freeSet } from '@coreui/icons'
import axios from 'axios'

export default {
  name: 'data',
  freeSet,
  data: () => {
    return {
      items: [],
      fields: ['id', 'tanggal', 'kode', 'nik', 'nama', 'departemen', 'action'],
      currentPage: 1,
      perPage: 10,
      totalRows: 0,
      you: null,
      message: '',
      showMessage: false,
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false,
      modalCreate: false,
    }
  },
  paginationProps: {
    align: 'center',
    doubleArrows: false,
    previousButtonHtml: 'prev',
    nextButtonHtml: 'next'
  },
  methods: {
    reload () {
        this.getData();
    },
    createNew () {
        alert("A");
    },
    editRow ( id ) {
      const editLink = this.editLink( id );
      this.$router.push({path: editLink});
    },
    editLink (id) {
      return `inventory/${id.toString()}/edit`
    },
    deleteRow ( id ) {
      let self = this;
      let userId = id;
      axios.post(  this.$apiAdress + '/api/inventory/' + id + '?token=' + localStorage.getItem("api_token"), {
        _method: 'DELETE'
      })
      .then(function (response) {
          self.message = 'Deleted Success.';
          self.showAlert();
          self.getData();
      }).catch(function (error) {
        console.log(error);
        self.$router.push({ path: '/login' });
      });
    },
    countDownChanged (dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
    showAlert () {
      this.dismissCountDown = this.dismissSecs
    },
    getData (){
      let self = this;
      axios.get(  this.$apiAdress + '/api/inventory?token=' + localStorage.getItem("api_token"))
      .then(function (response) {
        self.items = response.data.result;
        self.you = response.data.you;
      });
    }
  },
  mounted: function(){
    this.getData();
  }
}
</script>

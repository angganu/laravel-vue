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
              <CButton color="primary" class="mb-2" @click="modalCreate = true"
                >Buat Permintaan Baru</CButton
              >
              <CButton color="light" class="mb-2 float-right" @click="reload()"
                ><CIcon :content="$options.freeSet.cilReload"
              /></CButton>
              <CAlert :show.sync="dismissCountDown" color="info" fade>
                ({{ dismissCountDown }}) {{ message }}
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
                    <CButton
                      color="success"
                      size="sm"
                      class="mr-2"
                      @click="editRow(item.id)"
                      >Edit</CButton
                    >
                    <CButton
                      color="danger"
                      size="sm"
                      @click="deleteRow(item.id)"
                      >Delete</CButton
                    >
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
      <CForm>
        <div class="row">
          <div class="col-md-12">
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Tanggal Permintaan</label>
                <date-picker
                  v-model="formModel.tanggal"
                  :config="options"
                ></date-picker>
              </div>
              <div class="col-md-6">
                <label>NIK Peminta</label>
                <v-select
                  label="nik"
                  :filterable="false"
                  :options="selectOptions"
                  @search="onSearchSelect"
                  @input="changeNIK"
                >
                  <template slot="no-options">
                    Cari NIK Pegawai
                  </template>
                  <template slot="option" slot-scope="selectOptions">
                    <div class="d-center">
                      {{ selectOptions.nik }}
                    </div>
                  </template>
                  <template slot="selected-option" slot-scope="selectOptions">
                    <div class="selected d-center" >
                      {{ formModel.nik }}
                    </div>
                  </template>
                </v-select>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-6">
                <CInput
                  label="Nama Peminta"
                  type="text"
                  v-model="formModel.nama"
                  readonly
                ></CInput>
              </div>
              <div class="col-md-6">
                <CInput
                  label="Departemen"
                  type="text"
                  v-model="formModel.departemen"
                  readonly
                ></CInput>
              </div>
            </div>
          </div>
        </div>
      </CForm>
      <template #header>
        <h6 class="modal-title">Tambah Permintaan Barang</h6>
        <CButtonClose @click="modalCreate = false" class="text-white" />
      </template>
      <template #footer>
        <CButton @click="modalCreate = false" color="secondary">Batal</CButton>
        <CButton @click="store()" color="primary">Proses</CButton>
      </template>
    </CModal>
  </div>
</template>

<script>
import { freeSet } from "@coreui/icons";
import axios from "axios";

import datePicker from "vue-bootstrap-datetimepicker";
import "pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css";
import "vue-select/dist/vue-select.css";

export default {
  freeSet,
  data: () => {
    return {
      items: [],
      selectOptions: [],
      fields: ["id", "tanggal", "kode", "nik", "nama", "departemen", "action"],
      currentPage: 1,
      perPage: 10,
      totalRows: 0,
      you: null,
      message: "",
      showMessage: false,
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false,
      modalCreate: false,
      options: {
        format: "DD/MM/YYYY h:mm:ss",
        useCurrent: false,
        showClear: true,
        showClose: true,
      },
      formModel: {
        tanggal: new Date(),
        id_employee: "",
        nik: "",
        nama: "",
        departemen: "",
      },
    };
  },
  components: {
    datePicker,
  },
  paginationProps: {
    align: "center",
    doubleArrows: false,
    previousButtonHtml: "prev",
    nextButtonHtml: "next",
  },
  methods: {
    onSearchSelect(search, loading) {
      if (search.length) {
        loading(true);
        this.searchSelect(loading, search, this);
      }
    },
    searchSelect: _.debounce((loading, search, vm) => {
      fetch(
        vm.$apiAdress +
          "/api/employee?token=" +
          localStorage.getItem("api_token") +
          "&search=" +
          `${escape(search)}`
      ).then((res) => {
        res.json().then((json) => (vm.selectOptions = json.result));
        loading(false);
      });
    }, 350),
    changeNIK(val) {
      this.formModel.id_employee = val.id;
      this.formModel.nama = val.nama;
      this.formModel.departemen = val.departemen;
      this.formModel.nik = val.nik;
    },
    reload() {
      this.getData();
    },
    createNew() {
      alert("A");
    },
    store() {
      let self = this;
      axios
        .post(
          this.$apiAdress +
            "/api/inventory?token=" +
            localStorage.getItem("api_token"),
          self.formModel
        )
        .then(function(response) {
          self.formModel = {
            tanggal: new Date(),
            id_employee: "",
            nik: "",
            nama: "",
            departemen: "",
          };
          self.message = "Permintaan baru berhasil dibuat.";
          self.showAlert();
          self.getData();
          self.modalCreate = false;
        })
        .catch(function(error) {
          if (error.response.data.message == "The given data was invalid.") {
            self.message = "";
            for (let key in error.response.data.errors) {
              if (error.response.data.errors.hasOwnProperty(key)) {
                self.message += error.response.data.errors[key][0] + "  ";
              }
            }
            self.showAlert();
          } else {
            console.log(error);
            self.$router.push({ path: "login" });
          }
        });
    },
    editRow(id) {
      const editLink = this.editLink(id);
      this.$router.push({ path: editLink });
    },
    editLink(id) {
      return `inventory/${id.toString()}/edit`;
    },
    deleteRow(id) {
      let self = this;
      let userId = id;
      axios
        .post(
          this.$apiAdress +
            "/api/inventory/" +
            id +
            "?token=" +
            localStorage.getItem("api_token"),
          {
            _method: "DELETE",
          }
        )
        .then(function(response) {
          self.message = "Deleted Success.";
          self.showAlert();
          self.getData();
        })
        .catch(function(error) {
          console.log(error);
          self.$router.push({ path: "/login" });
        });
    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    getData() {
      let self = this;
      axios
        .get(
          this.$apiAdress +
            "/api/inventory?token=" +
            localStorage.getItem("api_token")
        )
        .then(function(response) {
          self.items = response.data.result;
          self.you = response.data.you;
        });
    },
  },
  mounted: function() {
    this.getData();
  },
};
</script>

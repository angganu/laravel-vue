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
              <CButton color="primary" class="mb-2" @click="modalCreateShow"
                >Buat Permintaan Baru</CButton
              >
              <CButton color="light" class="mb-2 float-right" @click="reload()"
                ><CIcon :content="$options.freeSet.cilReload"
              /> Reload</CButton>
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
                <template ##="{item,index}">
                  <td>
                    {{ index + 1 }}
                  </td>
                </template>
                <template #action="{item}">
                  <td>
                    <CButton
                      color="info"
                      size="sm"
                      class="mr-2"
                      @click="viewRow(item.id)"
                      >Lihat</CButton
                    >
                    <CButton
                      color="danger"
                      size="sm"
                      @click="deleteRow(item.id)"
                      >Hapus</CButton
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
      :show.sync="modalPreview"
      :no-close-on-backdrop="true"
      :centered="true"
      title="Detil Permintaan Barang"
      size="lg"
      color="dark"
    >
      <div class="row">
        <div class="col-md-3">
          <label>Tanggal Permintaan</label>
          <input class="form-control disabled-input" v-model="detailView.tanggal" disabled />
        </div>
        <div class="col-md-3">
          <label>NIK Peminta</label>
          <input class="form-control disabled-input" v-model="detailView.nik" disabled />
        </div>
        <div class="col-md-3">
          <label>Nama Peminta</label>
          <input class="form-control disabled-input" v-model="detailView.nama" disabled />
        </div>
        <div class="col-md-3">
          <label>Departemen</label>
          <input class="form-control disabled-input" v-model="detailView.departemen" disabled />
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-md-12">
          <h5>Daftar Permintaan Barang</h5>
          <table class="table mb-0">
            <thead>
              <tr>
                <th width="5%">#</th>
                <th width="35%">Barang</th>
                <th width="15%">Lokasi</th>
                <th width="15%">Kuantiti</th>
                <th width="15%">Satuan</th>
                <th width="15%">Keterangan</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(barang, index) in detailView.list_barang">
                <td>{{ index + 1 }}</td>
                <td><input class="form-control disabled-input" v-model="barang.nama_Barang" disabled /></td>
                <td><input class="form-control disabled-input" v-model="barang.nama_lokasi" disabled /></td>
                <td><input class="form-control disabled-input" v-model="barang.kuantiti" disabled /></td>
                <td><input class="form-control disabled-input" v-model="barang.nama_satuan" disabled /></td>
                <td><input class="form-control disabled-input" v-model="barang.keterangan" disabled /></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <template #footer>
        <CButton color="primary">Ok</CButton>
      </template>
    </CModal>

    <CModal
      :show.sync="modalCreate"
      :no-close-on-backdrop="true"
      :centered="true"
      title="Tambah Permintaan Barang"
      size="xl"
      color="dark"
    >
      <CForm>
        <div class="row">
          <div class="col-md-12">
            <CAlert color="danger" closeButton :show.sync="alertSubmit">
              {{ alertSubmitText }}
            </CAlert>
            <div class="row">
              <div class="col-md-3">
                <label>Tanggal Permintaan</label>
                <date-picker
                  v-model="formModel.tanggal"
                  :config="options"
                ></date-picker>
              </div>
              <div class="col-md-3">
                <label>NIK Peminta</label>
                <v-select
                  label="nik"
                  :filterable="false"
                  :options="selectOptions"
                  @search="onSearchSelect"
                  @input="changeNIK"
                >
                  <template slot="no-options">
                    Silahkan Ketik NIK Pegawai
                  </template>
                  <template slot="option" slot-scope="selectOptions">
                    <div class="d-center">
                      {{ selectOptions.nik }}
                    </div>
                  </template>
                  <template slot="selected-option" slot-scope="selectOptions">
                    <div class="selected d-center">
                      {{ formModel.nik }}
                    </div>
                  </template>
                </v-select>
              </div>
              <div class="col-md-3">
                <CInput
                  label="Nama Peminta"
                  type="text"
                  v-model="formModel.nama"
                  readonly
                ></CInput>
              </div>
              <div class="col-md-3">
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
        <div class="row mt-4">
          <div class="col-md-12">
            <CButton
              @click="addBarang()"
              color="info"
              size="sm"
              class="pull-right mb-1"
              ><i class="fa fa-plus"></i> Tambah Item</CButton
            >
            <h5>Daftar Permintaan Barang</h5>
            <table class="table mb-0">
              <thead>
                <tr>
                  <th width="2%">#</th>
                  <th width="27%">Barang</th>
                  <th width="13%">Lokasi</th>
                  <th width="10%">Tersedia</th>
                  <th width="10%">Kuantiti</th>
                  <th width="10%">Satuan</th>
                  <th width="15%">Keterangan</th>
                  <th width="11%">Status</th>
                  <th width="2%">#</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(barang, index) in formModel.list_barang">
                  <td>{{ index + 1 }}</td>
                  <td>
                    <v-select
                      label="kode_barang"
                      :filterable="false"
                      :options="selectBarang"
                      @open="selectingRow(index)"
                      @search="onSearchBarang"
                      @input="changeBarang"
                    >
                      <template slot="no-options">
                        Silahkan Ketik Kode Barang
                      </template>
                      <template slot="option" slot-scope="selectBarang">
                        <div class="d-center">
                          {{
                            selectBarang.kode_barang +
                              " - " +
                              selectBarang.nama_barang
                          }}
                        </div>
                      </template>
                      <template
                        slot="selected-option"
                        slot-scope="selectBarang"
                      >
                        <div class="selected d-center">
                          {{
                            formModel.list_barang[index].kode_barang +
                              " - " +
                              formModel.list_barang[index].nama_barang
                          }}
                        </div>
                      </template>
                    </v-select>
                  </td>
                  <td>
                    <input
                      class="form-control"
                      v-model="formModel.list_barang[index].lokasi"
                      readonly
                    />
                  </td>
                  <td>
                    <input
                      class="form-control"
                      v-model="formModel.list_barang[index].stock"
                      readonly
                    />
                  </td>
                  <td>
                    <input
                      class="form-control"
                      type="number"
                      v-on:keyup="cekQty(index, $event.target.value)"
                      v-model="formModel.list_barang[index].kuantiti"
                    />
                  </td>
                  <td>
                    <input
                      class="form-control"
                      v-model="formModel.list_barang[index].satuan"
                      readonly
                    />
                  </td>
                  <td>
                    <input
                      class="form-control"
                      v-model="formModel.list_barang[index].keterangan"
                    />
                  </td>
                  <td>
                    <CBadge color="success">{{
                      formModel.list_barang[index].status
                    }}</CBadge>
                  </td>
                  <td>
                    <CButton @click="removeRow(index)" size="sm" color="danger"
                      ><i class="fa fa-trash"></i
                    ></CButton>
                  </td>
                </tr>
              </tbody>
            </table>
            {{ alertEmpty }}
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
      selectBarang: [],
      fields: ["#", "tanggal", "kode", "nik", "nama", "departemen", "action"],
      currentPage: 1,
      perPage: 10,
      totalRows: 0,
      you: null,
      message: "",
      modalPreview: false,
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
      detailView: {
        tanggal: "",
        nik: "",
        nama: "",
        departemen: "",
        list_barang: [],
      },
      formModel: {
        tanggal: new Date(),
        id_employee: "",
        nik: "",
        nama: "",
        departemen: "",
        list_barang: [],
      },
      rowIndex: 0,
      alertEmpty: "",
      alertSubmit: false,
      alertSubmitText: "",
      selectedRow: "",
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
    onSearchBarang(search, loading) {
      if (search.length) {
        loading(true);
        this.searchBarang(loading, search, this);
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
    searchBarang: _.debounce((loading, search, vm) => {
      fetch(
        vm.$apiAdress +
          "/api/barang?token=" +
          localStorage.getItem("api_token") +
          "&search=" +
          `${escape(search)}`
      ).then((res) => {
        res.json().then((json) => (vm.selectBarang = json.result));
        loading(false);
      });
    }, 350),
    changeNIK(val) {
      this.formModel.id_employee = val.id;
      this.formModel.nama = val.nama;
      this.formModel.departemen = val.departemen;
      this.formModel.nik = val.nik;
    },
    changeBarang(val) {
      this.formModel.list_barang[this.selectedRow].id = val.id;
      this.formModel.list_barang[this.selectedRow].kode_barang =
        val.kode_barang;
      this.formModel.list_barang[this.selectedRow].nama_barang =
        val.nama_barang;
      this.formModel.list_barang[this.selectedRow].lokasi = val.lokasi;
      this.formModel.list_barang[this.selectedRow].stock = val.stock;
      this.formModel.list_barang[this.selectedRow].satuan = val.satuan;
      this.formModel.list_barang[this.selectedRow].status =
        val.stock > 0 ? "Tidak Sesuai" : "Kosong";
      this.alertEmpty = "";
    },
    reload() {
      this.getData();
    },
    modalCreateShow() {
      this.selectBarang = [];
      this.formModel = {
        tanggal: new Date(),
        id_employee: "",
        nik: "",
        nama: "",
        departemen: "",
        list_barang: [],
      };
      this.rowIndex = 0;
      this.alertEmpty = "";
      this.selectedRow = "";
      this.modalCreate = true;
      this.addBarang();
    },
    addBarang() {
      if (this.formModel.list_barang.length > 0) {
        if (this.formModel.list_barang[this.rowIndex].id == "") {
          this.alertEmpty = "* Silahkan isi atau hapus kolom yang kosong.";
        } else {
          this.pushRow();
        }
      } else {
        this.pushRow();
      }
    },
    selectingRow(idx) {
      this.selectedRow = idx;
    },
    pushRow() {
      this.rowIndex =
        this.formModel.list_barang.push({
          id: "",
          kode_barang: "",
          nama_barang: "",
          lokasi: "",
          stock: "",
          satuan: "",
          kuantiti: "",
          keterangan: "",
          status: "Tidak Sesuai",
        }) - 1;
    },
    viewRow(id) {
      this.modalPreview = true;
      this.detailView = {
        tanggal: "",
        nik: "",
        nama: "",
        departemen: "",
        list_barang: [],
      };
      this.getDetailInventory(id);
    },
    removeRow(idx) {
      this.formModel.list_barang.splice(idx, 1);
      this.rowIndex = this.rowIndex - 1;
      this.alertEmpty = "";
    },
    cekQty(index, value) {
      console.log(index);
      console.log(this.formModel.list_barang);
      var stock = this.formModel.list_barang[index].stock;
      if (stock < value || value == 0 || value == "") {
        this.formModel.list_barang[index].status = "Tidak Sesuai";
      } else {
        this.formModel.list_barang[index].status = "Terpenuhi";
      }
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
            list_barang: [],
          };
          self.rowIndex = 0;
          self.alertEmpty = "";
          self.selectedRow = "";
          self.message = "Permintaan baru berhasil dibuat.";
          self.showAlert();
          self.getData();
          self.modalCreate = false;
        })
        .catch(function(error) {
          if (error.response.data.message == "The given data was invalid.") {
            self.alertSubmitText = "";
            for (let key in error.response.data.errors) {
              if (error.response.data.errors.hasOwnProperty(key)) {
                self.alertSubmitText +=
                  error.response.data.errors[key][0] + "  ";
              }
            }
            self.alertSubmit = true;
          } else {
            self.alertSubmit = true;
            self.alertSubmitText = error.response.data.message;
            // self.$router.push({ path: 'login' });
          }
        });
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
        })
        .catch(function(error) {
          console.log(error);
          self.$router.push({ path: "/login" });
        });
    },
    getDetailInventory(id) {
      let self = this;
      axios
        .get(
          this.$apiAdress +
            "/api/detail?id="+id+"&token=" +
            localStorage.getItem("api_token")
        )
        .then(function(response) {
          self.detailView = {
            tanggal: response.data.result.tanggal,
            nik: response.data.result.nik,
            nama: response.data.result.nama,
            departemen: response.data.result.departemen,
            list_barang: response.data.detail,
          };
          console.log(self.detailView);
        })
        .catch(function(error) {
          console.log(error);
          // self.$router.push({ path: "/login" });
        });
    },
  },
  mounted: function() {
    this.getData();
  },
};
</script>

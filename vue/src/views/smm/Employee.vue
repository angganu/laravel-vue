<template>
  <CRow>
    <CCol col="12" xl="12">
      <transition name="slide">
        <CCard>
          <CCardHeader>
            Employee
          </CCardHeader>
          <CCardBody>
            <CAlert :show.sync="dismissCountDown" color="primary" fade>
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
            </CDataTable>
          </CCardBody>
        </CCard>
      </transition>
    </CCol>
  </CRow>
</template>

<script>
import axios from "axios";

export default {
  name: "data",
  data: () => {
    return {
      items: [],
      fields: ["#", "nik", "nama", "departemen"],
      currentPage: 1,
      perPage: 10,
      totalRows: 0,
      you: null,
      message: "",
      showMessage: false,
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false,
    };
  },
  paginationProps: {
    align: "center",
    doubleArrows: false,
    previousButtonHtml: "prev",
    nextButtonHtml: "next",
  },
  methods: {
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
            "/api/employee?token=" +
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
  },
  mounted: function() {
    this.getData();
  },
};
</script>

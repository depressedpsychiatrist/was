<template>
  <div class="form-body">
    <div class="row">
      <div class="form-holder">
        <div class="form-content pt-0">
          <div class="form-items">
            <h3>Submission Form</h3>
            <p>Fill in the data below.</p>
            <form @submit.prevent="submit()" novalidate>
              <div class="col-md-12">
                <input
                  class="form-control"
                  type="text"
                  name="name"
                  v-model="employee.name"
                  placeholder="Full Name"
                  required
                />
                <small
                  v-if="v$.employee.name.$error"
                  class="invalid-feedback d-block"
                >{{ v$.employee.name.$errors[0].$message }}</small>
              </div>

              <div class="col-md-12">
                <input
                  class="form-control"
                  type="text"
                  name="id_number"
                  v-model="employee.id_number"
                  placeholder="ID"
                  required
                />
                <small
                  v-if="v$.employee.id_number.$error"
                  class="invalid-feedback d-block"
                >{{ v$.employee.id_number.$errors[0].$message }}</small>
              </div>

              <div class="col-md-12">
                <input
                  class="form-control"
                  type="email"
                  name="email"
                  v-model="employee.email"
                  placeholder="E-mail Address"
                  required
                />
                <small
                  v-if="v$.employee.email.$error"
                  class="invalid-feedback d-block"
                >{{ v$.employee.email.$errors[0].$message }}</small>
              </div>

              <div class="col-md-12">
                <select class="form-select mt-3" v-model="employee.department_id" required>
                  <option disabled :value="null">Select Department</option>
                  <option
                    :value="department.id"
                    v-for="department in departments"
                    :key="department.id"
                  >{{department.name}}</option>
                </select>
                <small
                  v-if="v$.employee.department_id.$error"
                  class="invalid-feedback d-block"
                >{{ v$.employee.department_id.$errors[0].$message }}</small>
              </div>

              <div class="col-md-12 mt-3">
                <label class="mb-3 me-2" for="gender">Employment Status:</label>
                <template v-for="(status, index) in employmentStatuses" :key="index">
                  <input
                    type="radio"
                    class="btn-check"
                    name="gender"
                    v-model="employee.employment_status_id"
                    :value="status.id"
                    :id="status.id"
                    autocomplete="off"
                    required
                  />
                  <label
                    class="btn btn-sm btn-outline-secondary me-1"
                    :for="status.id"
                  >{{status.name}}</label>
                </template>
                <small
                  v-if="v$.employee.employment_status_id.$error"
                  class="invalid-feedback d-block"
                >{{ v$.employee.employment_status_id.$errors[0].$message }}</small>
              </div>

              <div class="col-md-12 mt-1">
                <label class="mb-3 me-2" for="gender">Documentation:</label>
                <input
                  type="file"
                  ref="fileSelector"
                  @change="fileChange($event.target.files)"
                  class="form-control d-inline w-auto"
                />
                <small
                  v-if="v$.employee.documentation.$error"
                  class="invalid-feedback d-block"
                >{{ v$.employee.documentation.$errors[0].$message }}</small>
              </div>

              <div class="form-check">
                <input
                  class="form-check-input"
                  v-model="confirmation_check"
                  type="checkbox"
                  value
                  id="invalidCheck"
                  required
                />
                <label class="form-check-label">I confirm that all data are correct</label>
                <small
                  v-if="v$.confirmation_check.$error"
                  class="invalid-feedback d-block"
                >{{ v$.confirmation_check.$errors[0].$message }}</small>
              </div>

              <div class="form-button mt-3">
                <button id="submit" type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import useValidate from "@vuelidate/core";
import { required, email, helpers, checked } from "@vuelidate/validators";
import axios from "axios";
export default {
  data() {
    return {
      v$: useValidate(),
      employee: {
        department_id: null,
        documentation: null,
      },
      confirmation_check: false,
    };
  },
  validations() {
    return {
      employee: {
        name: {
          required: helpers.withMessage("Please enter a name.", required),
        },
        id_number: {
          required: helpers.withMessage("Please enter an ID.", required),
        },
        email: {
          required: helpers.withMessage("Please enter an email.", required),
          email: helpers.withMessage("Please enter a valid email.", email),
        },
        department_id: {
          required: helpers.withMessage(
            "Please select a department.",
            required
          ),
        },
        employment_status_id: {
          required: helpers.withMessage(
            "Please select an employment status.",
            required
          ),
        },
        documentation: {
          required: helpers.withMessage(
            "Please upload a documentation.",
            required
          ),
        },
      },
      confirmation_check: {
        checked: helpers.withMessage(
          "Please confirm that the entered data are all correct.",
          (value) => value === true
        ),
      },
    };
  },
  methods: {
    fileChange(fileList) {
      if (fileList.length == 0) {
        this.employee.documentation = null;
        return;
      }
      var imageFile = fileList[0];
      this.employee.documentation = imageFile;
      return;
    },
    submit() {
      this.v$.$validate();
      if (!this.v$.$error) {
        let fd = new FormData();
        fd.append("name", this.employee.name);
        fd.append("id_number", this.employee.id_number);
        fd.append("email", this.employee.email);
        fd.append("department_id", this.employee.department_id);
        fd.append("employment_status_id", this.employee.employment_status_id);
        fd.append("documentation", this.employee.documentation);
        fd.append("_method", "POST");
        axios
          .post("employee", fd, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((response) => {
            this.$toast.success("Your information was submitted successfully.");
            this.v$.$reset();
            this.employee = {
              department_id: null,
              documentation: null,
            };
            this.$refs.fileSelector.value = "";
          })
          .catch((error) => {
            this.$toast.danger(
              "An error occurred while submitting your information."
            );
            console.log(error);
          });
      }
    },
  },
  computed: {
    departments() {
      return this.$store.getters.departments;
    },
    employmentStatuses() {
      return this.$store.getters.employmentStatuses;
    },
  },
};
</script>

<style>
.form-holder {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  min-height: 100vh;
}

.form-holder .form-content {
  position: relative;
  text-align: center;
  display: -webkit-box;
  display: -moz-box;
  display: -ms-flexbox;
  display: -webkit-flex;
  display: flex;
  -webkit-justify-content: center;
  justify-content: center;
  -webkit-align-items: center;
  align-items: center;
  padding: 60px;
}

.form-content .form-items {
  border: 3px solid #fff;
  padding: 40px;
  display: inline-block;
  width: 100%;
  min-width: 540px;
  -webkit-border-radius: 10px;
  -moz-border-radius: 10px;
  border-radius: 10px;
  text-align: left;
  -webkit-transition: all 0.4s ease;
  transition: all 0.4s ease;
}

.form-content h3 {
  color: #fff;
  text-align: left;
  font-size: 28px;
  font-weight: 600;
  margin-bottom: 5px;
}

.form-content h3.form-title {
  margin-bottom: 30px;
}

.form-content p {
  color: #fff;
  text-align: left;
  font-size: 17px;
  font-weight: 300;
  line-height: 20px;
  margin-bottom: 30px;
}

.form-content label,
.was-validated .form-check-input:invalid ~ .form-check-label,
.was-validated .form-check-input:valid ~ .form-check-label {
  color: #fff;
}

.form-content input[type="text"],
.form-content input[type="password"],
.form-content input[type="email"],
.form-content select {
  width: 100%;
  padding: 9px 20px;
  text-align: left;
  border: 0;
  outline: 0;
  border-radius: 6px;
  background-color: #fff;
  font-size: 15px;
  font-weight: 300;
  color: #8d8d8d;
  -webkit-transition: all 0.3s ease;
  transition: all 0.3s ease;
  margin-top: 16px;
}

.btn-primary {
  background-color: #6c757d;
  outline: none;
  border: 0px;
  box-shadow: none;
}

.btn-primary:hover,
.btn-primary:focus,
.btn-primary:active {
  background-color: #495056;
  outline: none !important;
  border: none !important;
  box-shadow: none;
}

.form-content textarea {
  position: static !important;
  width: 100%;
  padding: 8px 20px;
  border-radius: 6px;
  text-align: left;
  background-color: #fff;
  border: 0;
  font-size: 15px;
  font-weight: 300;
  color: #8d8d8d;
  outline: none;
  resize: none;
  height: 120px;
  -webkit-transition: none;
  transition: none;
  margin-bottom: 14px;
}

.form-content textarea:hover,
.form-content textarea:focus {
  border: 0;
  background-color: #ebeff8;
  color: #8d8d8d;
}

.mv-up {
  margin-top: -9px !important;
  margin-bottom: 8px !important;
}

.invalid-feedback {
  color: #ff606e;
}

.valid-feedback {
  color: #2acc80;
}
</style>

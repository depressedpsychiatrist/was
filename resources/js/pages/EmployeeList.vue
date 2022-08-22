<template>
  <h5 class="font-bold mt-4">Employee List</h5>
  <form @submit.prevent="filterEmployees">
    <div class="row my-4">
      <h6 class="font-medium">Filters</h6>
      <div class="col-2">
        <input
          type="text"
          name="id"
          v-model="filter.id_number"
          class="form-control filter-input"
          placeholder="ID"
          :disabled="filter.email.length"
        />
      </div>
      <div class="col-2">
        <input
          name="email"
          v-model="filter.email"
          class="form-control filter-input"
          placeholder="Email"
          :disabled="filter.id_number.length"
        />
      </div>
      <div class="col-2">
        <input
          type="text"
          name="name"
          v-model="filter.name"
          class="form-control filter-input"
          placeholder="Name"
          :disabled="filter.id_number.length || filter.email.length"
        />
      </div>
      <div class="col-2">
        <select
          class="form-select filter-input"
          v-model="filter.department_id"
          required
          :disabled="filter.id_number.length || filter.email.length"
        >
          <option :value="null">Select Department</option>
          <option
            :value="department.id"
            v-for="department in departments"
            :key="department.id"
          >{{department.name}}</option>
        </select>
      </div>
      <div class="col-2">
        <select
          class="form-select filter-input"
          v-model="filter.employment_status_id"
          required
          :disabled="filter.id_number.length || filter.email.length"
        >
          <option :value="null">Select Employment Status</option>
          <option :value="status.id" v-for="status in statuses" :key="status.id">{{status.name}}</option>
        </select>
      </div>
      <div class="col-2">
        <button class="btn btn-outline-light font-bold" type="submit">Filter</button>
        <button class="btn btn-outline-light font-medium ms-2" @click="resetFilters">Reset filters</button>
      </div>
    </div>
  </form>
  <table class="table align-middle mb-4">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Department</th>
        <th>Employment Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="employee in employees.data" :key="employee.id">
        <td>
          <div class="d-flex align-items-center">
            <p class="fw-bold mb-1">{{employee.id_number}}</p>
          </div>
        </td>
        <td>
          <p class="fw-normal mb-1">{{employee.name}}</p>
        </td>
        <td>
          <p class="fw-normal mb-1">{{employee.email}}</p>
        </td>
        <td>
          <p class="fw-normal mb-1" v-if="departments">{{department(employee.department_id)}}</p>
        </td>
        <td>
          <p class="fw-normal mb-1" v-if="statuses">{{status(employee.employment_status_id)}}</p>
        </td>
        <td>
          <a
            type="button"
            :href="`/storage/documentation/${employee.documentation}`"
            target="_blank"
            class="btn btn-link btn-sm btn-rounded"
          >View Documentation</a>
        </td>
      </tr>
    </tbody>
  </table>
  <h6
    v-if="!employees.data || !employees.data.length"
    class="font-medium text-center mt-3"
  >No employees with specified filters.</h6>
  <Pagination
    class="justify-content-center custom-pagination"
    :data="employees"
    :limit="3"
    :show-disabled="true"
    style="--bs-pagination-active-border-color: white; --bs-pagination-color: #d3cece; --bs-pagination-bg: none; --bs-pagination-hover-color: black;  --bs-pagination-active-color: white; --bs-pagination-active-bg: none; --bs-pagination-disabled-color: white; --bs-pagination-disabled-bg: none;"
    @pagination-change-page="getEmployees"
  >
    <template #prev-nav>
      <span>&lt; Previous</span>
    </template>
    <template #active-nav>
      <span>Next &gt;</span>
    </template>
    <template #next-nav>
      <span>Next &gt;</span>
    </template>
  </Pagination>
</template>

<script>
import LaravelVuePagination from "laravel-vue-pagination";

export default {
  components: {
    Pagination: LaravelVuePagination,
  },
  data() {
    return {
      employees: [],
      filter: {
        id_number: "",
        email: "",
        name: "",
        department_id: null,
        employment_status_id: null,
      },
    };
  },
  methods: {
    getEmployees(page = 1) {
      axios
        .get(`/employees?page=` + page)
        .then((response) => {
          this.employees = response.data;
        })
        .catch((error) => {
          this.$toast.error(error.response.data.error);
        });
    },
    department(id) {
      return this.departments.find((department) => department.id == id).name;
    },
    status(id) {
      return this.statuses.find((status) => status.id == id).name;
    },
    filterEmployees() {
      axios
        .get(`/employees`, {
          params: {
            id_number: this.filter.id_number,
            email: this.filter.email,
            name: this.filter.name,
            department_id: this.filter.department_id,
            employment_status_id: this.filter.employment_status_id,
          },
        })
        .then((response) => {
          this.employees = response.data;
        })
        .catch((error) => {
          this.$toast.error(error.response.data.error);
        });
    },
    resetFilters() {
      this.filter = {
        id_number: "",
        email: "",
        name: "",
        department_id: null,
        employment_status_id: null,
      };
      this.getEmployees();
    },
  },
  computed: {
    departments() {
      if (this.$store.getters.departments[0]) {
        return this.$store.getters.departments;
      } else {
        return null;
      }
    },
    statuses() {
      if (this.$store.getters.employmentStatuses[0]) {
        return this.$store.getters.employmentStatuses;
      } else {
        return null;
      }
    },
  },
  mounted() {
    this.getEmployees();
  },
};
</script>

<style scoped>
th,
td {
  color: white !important;
}
.filter-input {
  background-color: transparent !important;
  border: 1px solid white;
  color: white !important;
}
.form-control:disabled {
  border: 1px solid gray !important;
}
select:disabled {
  opacity: 0.5 !important;
}
</style>

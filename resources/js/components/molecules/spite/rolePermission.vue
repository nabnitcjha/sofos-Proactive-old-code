<template>
  <div class="container-fluid role-permission" id="container-wrapper">
    <div
      class="d-sm-flex align-items-center justify-content-between mb-4"
    ></div>

    <div class="row">
      <div class="col-lg-12 mb-4">
        <!-- Simple Tables -->
        <div class="card">
          <div
            class="
              card-header
              py-3
              d-flex
              flex-row
              align-items-center
              justify-content-between
            "
          >
            <h6 class="m-0 font-weight-bold text-primary">Permission Info</h6>
          </div>
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th class="left-align">Role</th>
                  <th class="right-align" colspan="6">Permission</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(role, index) in rolePermission.roles" :key="index">
                  <td class="left-align" style="text-transform: capitalize">
                    {{ role.name }}
                  </td>

                  <td class="permission-mobo">
                    <span
                      class="custom-checkbox"
                      v-for="(permission, i) in rolePermission.permissions"
                      :key="i"
                      style="text-transform: capitalize"
                    >
                      <input
                        type="checkbox"
                        class="custom-control-input"
                        :id="permission.id + role.name + role.id"
                        @click="selectPermission(role, permission, $event)"
                        :checked="isPermissionChecked(role, permission)"
                      />
                      <label
                        class="custom-control-label"
                        :for="permission.id + role.name + role.id"
                        >{{ permission.name }}</label
                      >
                    </span>
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th>
                    <button
                      type="button"
                      class="btn btn-success"
                      @click.stop="savePermission"
                    >
                      Save
                    </button>
                  </th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- <div class="card-footer"></div> -->
        </div>
      </div>
    </div>
    <!--Row-->
  </div>
  <!-- <div class="rolePermission__page">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Role</th>
                    <th scope="col" colspan="6">Permission</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(role, index) in rolePermission.roles" :key="index">
                    <th class="tableIndex__page--data">
                        {{ index + 1 }}
                    </th>
                    <th
                        class="tableIndex__page--data"
                        style="text-transform:capitalize"
                    >
                        {{ role.name }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                    </th>

                    <th
                        class="tableIndex__page--data custom-checkbox"
                        v-for="(permission, i) in rolePermission.permissions"
                        :key="i"
                        style="text-transform:capitalize"
                    >
                        <input
                            type="checkbox"
                            class="custom-control-input"
                            :id="permission.id + role.name + role.id"
                            @click="selectPermission(role, permission, $event)"
                            :checked="isPermissionChecked(role, permission)"
                        />
                        <label
                            class="custom-control-label"
                            :for="permission.id + role.name + role.id"
                            >{{ permission.name }}</label
                        >
                        &nbsp;&nbsp;&nbsp;
                    </th>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>
                        <button
                            type="button"
                            class="btn btn-success"
                            @click.stop="savePermission"
                        >
                            Save
                        </button>
                    </th>
                </tr>
            </tfoot>
        </table>
    </div> -->
</template>

<script>
import formMixins from "../../../Mixins/form";
import "./style.css";
import "./rolepermission.css";
export default {
  data() {
    return {
      rolePermission: {
        roles: [],
        permissions: [],
      },
      isRepeat: false,
      roleHasPermission: [],
      checkbox: "",
      isChecked: false,
      finalRolePermissions: [
        {
          role: "teacher",
          permissions: [],
        },
        {
          role: "student",
          permissions: [],
        },
        {
          role: "parent",
          permissions: [],
        },
      ],
    };
  },
  methods: {
    savePermission() {
      axios
        .post("/api/savePermissions", this.finalRolePermissions)
        .then((response) => {
          this.permssionSave();
        });
    },
    isPermissionChecked(role, permission) {
      let result = this.roleHasPermission.find((data) => {
        return data.permission_id == permission.id && data.role_id == role.id;
      });
      if (result == undefined) {
        return false;
      } else {
        if (!this.isRepeat) {
          this.selectPermission(role, permission, "");
        }

        return true;
      }
    },
    permssionSave() {
      this.$toast.open({
        message: "Permissions assigned to Role successfully",
        type: "success",
        duration: 5000,
        dismissible: true,
      });
    },
    selectPermission(role, permission, event) {
      if (event == "" && !this.isRepeat) {
        this.assignPermission(role, permission);
      } else {
        if (event != "") {
          this.isRepeat = true;
          this.assignPermission(role, permission);
        }
      }
    },
    assignPermission(role, permission) {
      let finalRolePermissions = [...this.finalRolePermissions];
      let checkedItem = finalRolePermissions.find(
        (finalRolePermission) => finalRolePermission.role === role.name
      );
      let permissions = checkedItem.permissions;
      if (permissions.includes(permission.name)) {
        permissions = permissions.filter((pm) => pm !== permission.name);
      } else {
        permissions.push(permission.name);
      }
      checkedItem.permissions = permissions;
      this.finalRolePermissions = finalRolePermissions;
    },
    getRole() {
      this.setTokenToHeader();
      axios.get("/api/getRoles").then((response) => {
        this.rolePermission = {
          ...this.rolePermission,
          roles: response.data,
        };
      });
    },
    getPermission() {
      this.setTokenToHeader();
      axios.get("/api/getPermissions").then((response) => {
        this.rolePermission = {
          ...this.rolePermission,
          permissions: response.data,
        };
      });
    },
    getRoleHasPermissions() {
      axios.get("/api/getRoleHasPermissions").then((response) => {
        let roleHasPerm = [...this.roleHasPermission];
        roleHasPerm = response.data;
        this.roleHasPermission = roleHasPerm;
        this.getRole();
        this.getPermission();
      });
    },
  },
  mounted() {
    this.getRoleHasPermissions();
  },
  mixins: [formMixins],
};
</script>

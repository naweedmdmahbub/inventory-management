<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input v-model="query.keyword" :placeholder="$t('table.keyword')" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter" />
      <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">
        {{ $t('table.search') }}
      </el-button>
      <el-button v-permission="['add unit']" class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-plus" @click="handleCreate">
        {{ $t('table.add') }}
      </el-button>
      <el-button v-waves :loading="downloading" class="filter-item" type="primary" icon="el-icon-download" @click="handleDownload">
        {{ $t('table.export') }}
      </el-button>
    </div>

    <!-- <div class="row">
      <div class="col">
        <div v-if="errors_exist" class="alert alert-danger" role="alert">
          Whoops! Something didn't work.
          <ul>
            <div v-for="(error, key) in errors" :key="key">
              <li>{{ key }} : {{ error[0] }}</li>
            </div>
          </ul>
        </div>
      </div>
    </div> -->

    <el-table v-loading="loading" :data="list" border fit highlight-current-row>
      <el-table-column align="center" label="ID" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column prop="name" align="center" sortable label="Name" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>

      <el-table-column prop="code" align="center" sortable label="Code">
        <template slot-scope="scope">
          <span>{{ scope.row.code }}</span>
        </template>
      </el-table-column>
      <el-table-column prop="status" align="center" sortable label="Status">
        <template slot-scope="scope">
          <span v-if="scope.row.status == 1">Active</span>
          <span v-else>Inactive</span>
        </template>
      </el-table-column>
      
      
      <el-table-column align="center" label="Actions" width="350">
        <template slot-scope="scope">
          <el-button v-permission="['view unit']" type="warning" size="small" icon="el-icon-view" @click="handleEditForm(scope.row.id, scope.row.name);">
            View
          </el-button>
          <el-button v-permission="['update unit']" type="primary" size="small" icon="el-icon-edit" @click="handleEditForm(scope.row.id, scope.row.name);">
            Edit
          </el-button>
          <el-button v-permission="['manage unit']" type="danger" size="small" icon="el-icon-delete" @click="handleDelete(scope.row.id, scope.row.name);">
            Delete
          </el-button>
        </template>
      </el-table-column>

    </el-table>


    

    <el-dialog :title="formTitle" :visible.sync="unitFormVisible">
      <div class="form-container">
        <el-form ref="unitForm" :model="currentUnit" label-position="left" label-width="150px" style="max-width: 500px;">
          <el-form-item label="Name" prop="name">
            <el-input v-model="currentUnit.name" />
          </el-form-item>
          <el-form-item label="Code" prop="code">
            <el-input v-model="currentUnit.code" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="unitFormVisible = false">
            Cancel
          </el-button>
          <el-button type="primary" @click="handleSubmit">
            Confirm
          </el-button>
        </div>
      </div>
    </el-dialog>


    <pagination 
      v-show="total>0"
      :total="total"
      :page.sync="query.page"
      :limit.sync="query.limit"
      @pagination="getList"
    />

    <!-- <div class="block">
      <el-pagination
        v-show="total > 0"
        background
        :page-sizes="[10, 100, 250, 500, 1000]"
        :page-size="query.limit"
        layout="sizes, prev, pager, next"
        :total="total"
        @size-change="handleSizeChange"
        @current-change="handleCurrentChange"
      >
      </el-pagination>  
    </div> -->
  </div>
</template>


<script>
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
import waves from '@/directive/waves'; // Waves directive
import axios from 'axios';
import permission from '@/directive/permission'; // Permission directive
import Resource from '@/api/resource';
const unitResource = new Resource('units');
// const permissionResource = new Resource('permissions');

export default {
  name: 'UnitList',
  components: { Pagination },
  directives: { waves, permission },
  data() {
    return {
      list: [],
      total: 0,
      loading: true,
      downloading: false,
      unitFormVisible: false,
      formTitle: 'Create Unit',
      currentUnit: {},
      query: {
        page: 1,
        limit: 10,
        keyword: '',
      },
      errors: [],
      // errors_exist: false,
    };
  },
  async mounted() {
    await this.getList();
  },
  methods: {
    /** For Pagination by using el-pagination */
    // handleSizeChange(val) {
    //   console.log(`${val} items per page`);
    //   this.getList();
    // },
    // handleCurrentChange(val) {
    //   console.log(`current page: ${val}`);
    //   this.query.page = val;
    //   this.getList();
    // },

    async getList() {
      this.loading = true;
      const response = await unitResource.list(this.query);
      // console.log('getList:', response, response.data);
      this.list = response.data;
      this.total = response.meta.total;
      this.loading = false;
    },
    handleFilter() {
      this.query.page = 1;
      this.getList();
    },
    handleCreate() {
      this.formTitle = 'Create unit';
      this.unitFormVisible = true;
      this.currentUnit = {
        name: '',
        code: '',
        description: '',
      };
    },
    handleEditForm(id) {
      this.formTitle = 'Edit unit';
      this.currentUnit = this.list.find(unit => unit.id === id);
      this.unitFormVisible = true;
    },


    handleSubmit() {
      // this.errors_exist = false;
      this.errors = [];
      var offset = 0;
      if (this.currentUnit.id !== undefined) {
        axios
          .put('api/units/'+this.currentUnit.id, this.currentUnit)
          .then(response => {
            this.$message({
              type: 'success',
              message: 'Unit info has been updated successfully',
              duration: 5 * 1000,
            });
            this.getList();
          })
          .catch(error => {
            this.errors = error.response.data.errors;
            Object.entries(this.errors).forEach(([key, value]) => {
              this.$notify.error({
                title: 'Error',
                message: value[0],
                offset: offset,
              });
              offset += 60;
            });
            this.getList();
          })
          .finally(() => {
            this.unitFormVisible = false;
          });
      } else {
        axios
          .post('api/units', this.currentUnit)
          .then(response => {
            this.$message({
              message: 'New unit ' + this.currentUnit.name + ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.currentUnit = {
              name: '',
              code: '',
              description: '',
            };
            this.unitFormVisible = false;
            this.getList();
          })
          .catch(error => {
            // this.errors_exist = true;
            this.errors = error.response.data.errors;
            var offset = 0;
            Object.entries(this.errors).forEach(([key, value]) => {
              // console.log('entries: ',key, value, value[0]);
              this.$notify.error({
                title: 'Error',
                message: value[0],
                offset: offset,
              });
              offset += 60;
            });
            // console.log('Error:', this.errors);
          });
        
        
        // unitResource
        //   .store(this.currentUnit)
        //   .then(response => {
        //     this.$message({
        //       message: 'New unit ' + this.currentUnit.name + ' has been created successfully.',
        //       type: 'success',
        //       duration: 5 * 1000,
        //     });
        //     this.currentUnit = {
        //       name: '',
        //       code: '',
        //       description: '',
        //     };
        //     this.unitFormVisible = false;
        //     this.getList();
        //   })
        //   .catch(error => {
        //     // this.errors_exist = true;
        //     this.errors = error.response.data.errors;
        //     var offset = 0;
        //     Object.entries(this.errors).forEach(([key, value]) => {
        //       // console.log('entries: ',key, value, value[0]);
        //       this.$notify.error({
        //         title: 'Error',
        //         message: value[0],
        //         offset: offset,
        //       });
        //       offset += 60;
        //     });
        //     // console.log('Error:', this.errors);
        //   });
  
      }
    },
    handleDelete(id, name) {
      this.$confirm('This will permanently delete unit ' + name + '. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        axios
          .delete('api/units/'+id)
          .then(response => {
            this.$message({
              type: 'success',
              message: 'Delete completed',
            });
            this.getList();
          }).catch(error => {
            console.log(error);
          });
      }).catch(() => {
        this.$message({
          type: 'info',
          message: 'Delete canceled',
        });
      });
    },


    handleDownload() {
      this.downloading = true;
      import('@/vendor/Export2Excel').then(excel => {
        const tHeader = ['id', 'name', 'code', 'description'];
        const filterVal = ['id', 'name', 'code', 'description'];
        const data = this.formatJson(filterVal, this.list);
        excel.export_json_to_excel({
          header: tHeader,
          data,
          filename: 'unit-list',
        });
        this.downloading = false;
      });
    },
    formatJson(filterVal, jsonData) {
      return jsonData.map(v => filterVal.map(j => v[j]));
    },
  },
};
</script>

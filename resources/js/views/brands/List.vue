<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input v-model="query.keyword" :placeholder="$t('table.keyword')" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter" />
      <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">
        {{ $t('table.search') }}
      </el-button>
      <el-button class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-plus" @click="handleCreate">
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

      <el-table-column align="center" label="Name" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Code" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.code }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Description">
        <template slot-scope="scope">
          <span>{{ scope.row.description }}</span>
        </template>
      </el-table-column>
    </el-table>



    <el-dialog :title="'Create new Brand'" :visible.sync="brandFormVisible">
      <div class="form-container">
        <el-form ref="brandForm" :model="currentBrand" label-position="left" label-width="150px" style="max-width: 500px;">
          <el-form-item label="Name" prop="name">
            <el-input v-model="currentBrand.name" />
          </el-form-item>
          <el-form-item label="Code" prop="code">
            <el-input v-model="currentBrand.code" />
          </el-form-item>
          <el-form-item label="Description" prop="description">
            <el-input v-model="currentBrand.description" type="textarea" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="brandFormVisible = false">
            Cancel
          </el-button>
          <el-button type="primary" @click="handleSubmit">
            Confirm
          </el-button>
        </div>
      </div>
    </el-dialog>


  </div>
</template>


<script>
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
import waves from '@/directive/waves'; // Waves directive
import permission from '@/directive/permission'; // Permission directive
import Resource from '@/api/resource';
const brandResource = new Resource('brands');
const permissionResource = new Resource('permissions');

export default {
  name: 'BrandList',
  components: { Pagination },
  directives: { waves, permission },
  data() {
    return {
      list: [],
      total: 0,
      loading: true,
      downloading: false,
      brandFormVisible: false,
      currentBrand: {},
      query: {
        page: 1,
        limit: 15,
        keyword: '',
      },
      errors: [],
      // errors_exist: false,
    };
  },
  async mounted() {
    console.log('hi');
    await this.getList();
  },
  methods: {
    async getList() {
      this.loading = true;
      console.log('loading:', this.loading, this.query);
      const { data } = await brandResource.list(this.query);
      console.log('getList:', data);
      this.list = data;
      this.loading = false;
    },
    handleFilter() {
      this.query.page = 1;
      this.getList();
    },
    handleCreate() {
      this.brandFormVisible = true;
      this.currentBrand = {
        name: '',
        code: '',
        description: '',
      };
    },


    handleSubmit() {
      // this.errors_exist = false;
      if (this.currentBrand.id !== undefined) {
        brandResource.update(this.currentBrand.id, this.currentBrand).then(response => {
          this.$message({
            type: 'success',
            message: 'Brand info has been updated successfully',
            duration: 5 * 1000,
          });
          this.getList();
        }).catch(error => {
          console.log(error);
        }).finally(() => {
          this.brandFormVisible = false;
        });
      } else {
        brandResource
          .store(this.currentBrand)
          .then(response => {
            this.$message({
              message: 'New brand ' + this.currentBrand.name + ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.currentBrand = {
              name: '',
              code: '',
              description: '',
            };
            this.brandFormVisible = false;
            this.getList();
          })
          .catch(error => {
            // this.errors_exist = true;
            this.errors = error.response.data.errors;
            var offset = 0;
            Object.entries(this.errors).forEach(([key, value]) => {
              // console.log('entries: ',key, value);
              console.log('entries: ', value[0]);
              this.$notify.error({
                title: 'Error',
                message: value[0],
                offset: offset,
              });
              offset += 60;
            });

            console.log('Error:', this.errors);
          });
      }
    },


    handleDownload() {
      this.downloading = true;
      import('@/vendor/Export2Excel').then(excel => {
        const tHeader = ['id', 'id', 'name', 'code', 'descirption'];
        const filterVal = ['index', 'id', 'name', 'code', 'descirption'];
        const data = this.formatJson(filterVal, this.list);
        excel.export_json_to_excel({
          header: tHeader,
          data,
          filename: 'user-list',
        });
        this.downloading = false;
      });
    },
  },
};
</script>

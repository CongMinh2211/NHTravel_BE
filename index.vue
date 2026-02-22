<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card radius-10 border-top border-0 border-3 border-info">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="mt-2"><b>DANH SÁCH SUẤT CHIẾU</b></h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        Thêm suất chiếu
                    </button>
                </div>
                <div class="card-body table-responsive">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search....">
                        <button class="btn btn-success input-group-text" style="width: 150px;">Tìm kiếm</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="bg-primary text-light text-nowrap">
                                    <th class="text-center">#</th>
                                    <th class="text-center">Tên Phim</th>
                                    <th class="text-center">Phòng Chiếu</th>
                                    <th class="text-center">Ngày Chiếu</th>
                                    <th class="text-center">Giờ Bắt Đầu</th>
                                    <th class="text-center">Giờ Kết Thúc</th>
                                    <th class="text-center">Tình Trạng</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(item, index) in list_suat_chieu" :key="index">
                                    <tr class="text-nowrap">
                                        <th class="align-middle text-center">{{ index + 1 }}</th>
                                        <td class="align-middle text-wrap">{{ item.ten_phim }}</td>
                                        <td class="align-middle text-center">{{ item.ten_phong }}</td>
                                        <td class="align-middle text-center">{{ item.ngay_chieu }}</td>
                                        <td class="align-middle text-center">{{ item.thoi_gian_bat_dau }}</td>
                                        <td class="align-middle text-center">{{ item.thoi_gian_ket_thuc }}</td>
                                        <td v-on:click="doiTrangThaiSuatChieu(item)" class="align-middle text-center">
                                            <button v-if="item.tinh_trang == 1" class="btn btn-success w-100"
                                                style="color: white;">
                                                Hoạt Động
                                            </button>
                                            <button v-else class="btn btn-danger w-100" style="color: white;">
                                                Đã Hủy
                                            </button>
                                        </td>
                                        <td class="align-middle text-center">
                                            <button class="btn btn-primary text-light me-2" data-bs-toggle="modal"
                                                data-bs-target="#taoVeModal" @click="info_ve = item">
                                                Tạo vé
                                            </button>
                                            <button class="btn btn-info text-light me-2" data-bs-toggle="modal"
                                                data-bs-target="#updateModal" @click="edit_suat_chieu = item">
                                                Cập nhật
                                            </button>
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" @click="del_suat_chieu = item">
                                                Xóa
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Thêm Mới -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Suất Chiếu Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phim</label>
                            <select class="form-select" v-model="create_suat_chieu.id_phim">
                                <option v-for="phim in list_phim" :key="phim.id" :value="phim.id">{{ phim.ten_phim }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phòng Chiếu</label>
                            <select class="form-select" v-model="create_suat_chieu.id_phong_chieu">
                                <option v-for="phong in list_phong" :key="phong.id" :value="phong.id">{{ phong.ten_phong
                                    }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Giờ Bắt Đầu</label>
                            <input type="time" class="form-control" v-model="create_suat_chieu.thoi_gian_bat_dau" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Giờ Kết Thúc</label>
                            <input type="time" class="form-control" v-model="create_suat_chieu.thoi_gian_ket_thuc" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ngày Chiếu</label>
                            <input type="date" class="form-control" v-model="create_suat_chieu.ngay_chieu" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tình Trạng</label>
                            <select class="form-select" v-model="create_suat_chieu.tinh_trang">
                                <option value="1">Hoạt Động</option>
                                <option value="0">Đã Hủy</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Đóng
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" v-on:click="themSuatChieu()">
                        Thêm mới
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cập Nhật -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cập Nhật Thông Tin Suất Chiếu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phim</label>
                            <select class="form-select" v-model="edit_suat_chieu.id_phim">
                                <option v-for="phim in list_phim" :key="phim.id" :value="phim.id">{{ phim.ten_phim }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phòng Chiếu</label>
                            <select class="form-select" v-model="edit_suat_chieu.id_phong_chieu">
                                <option v-for="phong in list_phong" :key="phong.id" :value="phong.id">{{ phong.ten_phong
                                    }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Giờ Bắt Đầu</label>
                            <input type="time" class="form-control" v-model="edit_suat_chieu.thoi_gian_bat_dau" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Giờ Kết Thúc</label>
                            <input type="time" class="form-control" v-model="edit_suat_chieu.thoi_gian_ket_thuc" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ngày Chiếu</label>
                            <input type="date" class="form-control" v-model="edit_suat_chieu.ngay_chieu" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tình Trạng</label>
                            <select class="form-select" v-model="edit_suat_chieu.tinh_trang">
                                <option value="1">Hoạt Động</option>
                                <option value="0">Đã Hủy</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Đóng
                    </button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal"
                        v-on:click="capNhatSuatChieu()">
                        Cập nhật
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Xóa -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xóa Suất Chiếu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        Bạn có chắc chắn muốn xóa suất chiếu phim
                        <strong>{{ del_suat_chieu.ten_phim }}</strong> vào ngày <strong>{{ del_suat_chieu.ngay_chieu
                            }}</strong>?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Đóng
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" v-on:click="xoaSuatChieu()">
                        Xác nhận
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tạo Vé -->
    <div class="modal fade" id="taoVeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tạo Vé Cho Suất Chiếu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        Bạn có chắc chắn muốn tạo vé cho phim
                        <strong>{{ info_ve.ten_phim }}</strong> vào ngày <strong>{{ info_ve.ngay_chieu
                            }}</strong>?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Đóng
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" v-on:click="taoVeAuto()">
                        Xác nhận
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            list_suat_chieu: [],
            list_phim: [],
            list_phong: [],
            create_suat_chieu: {
                id_phim: '',
                id_phong_chieu: '',
                ngay_chieu: '',
                thoi_gian_bat_dau: '',
                thoi_gian_ket_thuc: '',
                gia_ve: '',
                tinh_trang: 1
            },
            edit_suat_chieu: {},
            del_suat_chieu: {},
            info_ve: {}
        };
    },
    mounted() {
        this.layDataSuatChieu();
        this.layDataPhim();
        this.layDataPhong();
    },
    methods: {
        taoVeAuto() {
            axios
                .post('http://127.0.0.1:8000/api/admin/suat-chieu/tao-ve-auto', this.info_ve)
                .then(response => {
                    if (response.data.status) {
                        this.$toast.success(response.data.message);
                        this.layDataSuatChieu();
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
        },
        layDataSuatChieu() {
            axios
                .get('http://127.0.0.1:8000/api/admin/suat-chieu/get-data')
                .then(response => {
                    this.list_suat_chieu = response.data.data;
                })
        },
        layDataPhim() {
            axios
                .get('http://127.0.0.1:8000/api/admin/phim/get-data')
                .then(response => {
                    this.list_phim = response.data.data;
                })
        },
        layDataPhong() {
            axios
                .get('http://127.0.0.1:8000/api/admin/phong-chieu/get-data')
                .then(response => {
                    this.list_phong = response.data.data;
                })
        },
        themSuatChieu() {
            axios
                .post('http://127.0.0.1:8000/api/admin/suat-chieu/add-data', this.create_suat_chieu)
                .then(response => {
                    if (response.data.status) {
                        this.layDataSuatChieu();
                        this.create_suat_chieu = {
                            id_phim: '',
                            id_phong_chieu: '',
                            ngay_chieu: '',
                            thoi_gian_bat_dau: '',
                            thoi_gian_ket_thuc: '',
                            gia_ve: '',
                            tinh_trang: 1
                        };
                        this.$toast.success(response.data.message);
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
        },
        capNhatSuatChieu() {
            axios
                .post('http://127.0.0.1:8000/api/admin/suat-chieu/update', this.edit_suat_chieu)
                .then(response => {
                    if (response.data.status) {
                        this.$toast.success(response.data.message);
                        this.layDataSuatChieu();
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
        },
        xoaSuatChieu() {
            axios
                .post('http://127.0.0.1:8000/api/admin/suat-chieu/delete', this.del_suat_chieu)
                .then(response => {
                    if (response.data.status) {
                        this.layDataSuatChieu();
                        this.$toast.success(response.data.message);
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
        },
        doiTrangThaiSuatChieu(item) {
            axios
                .post('http://127.0.0.1:8000/api/admin/suat-chieu/change-status', item)
                .then(response => {
                    if (response.data.status) {
                        this.layDataSuatChieu();
                        this.$toast.success(response.data.message);
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
        }

    },
};
</script>

<style></style>
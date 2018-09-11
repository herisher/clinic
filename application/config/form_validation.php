<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config = array(
    '/system/login' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'required'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required'
        ),
    ),
    '/system/patient/new' => array(
        array(
            'field' => 'anamnesis',
            'label' => 'No. Rekam Medis',
            'rules' => 'required',
            ),
        array(
            'field' => 'patient_name',
            'label' => 'Nama Pasien',
            'rules' => 'required',
            ),
        array(
            'field' => 'patient_sex',
            'label' => 'Jenis Kelamin',
            'rules' => 'required',
            ),
        array(
            'field' => 'patient_dob',
            'label' => 'Tanggal Lahir',
            'rules' => 'required',
            ),
        array(
            'field' => 'address',
            'label' => 'Alamat',
            'rules' => '',
            ),
        array(
            'field' => 'phone_number',
            'label' => 'No. Telepon',
            'rules' => '',
            ),
        array(
            'field' => 'mobile_number',
            'label' => 'No. Telepon HP',
            'rules' => '',
            ),
    ),
    '/system/patient/patient_edit' => array(
        array(
            'field' => 'anamnesis',
            'label' => 'No. Rekam Medis',
            'rules' => 'required',
            ),
        array(
            'field' => 'patient_name',
            'label' => 'Nama Pasien',
            'rules' => 'required',
            ),
        array(
            'field' => 'patient_sex',
            'label' => 'Jenis Kelamin',
            'rules' => 'required',
            ),
        array(
            'field' => 'patient_dob',
            'label' => 'Tanggal Lahir',
            'rules' => 'required',
            ),
        array(
            'field' => 'address',
            'label' => 'Alamat',
            'rules' => '',
            ),
        array(
            'field' => 'phone_number',
            'label' => 'No. Telepon',
            'rules' => '',
            ),
        array(
            'field' => 'mobile_number',
            'label' => 'No. Telepon HP',
            'rules' => '',
            ),
    ),
    '/system/doctor/new' => array(
        array(
            'field' => 'doctor_name',
            'label' => 'Nama Dokter',
            'rules' => 'required',
            ),
        array(
            'field' => 'mobile_number',
            'label' => 'No. Telepon HP',
            'rules' => '',
            ),
    ),
    '/system/doctor/doctor_edit' => array(
        array(
            'field' => 'doctor_name',
            'label' => 'Nama Dokter',
            'rules' => 'required',
            ),
        array(
            'field' => 'mobile_number',
            'label' => 'No. Telepon HP',
            'rules' => '',
            ),
    ),
    '/system/checkup/new' => array(
        array(
            'field' => 'anamnesis',
            'label' => 'No. Rekam Medis',
            'rules' => 'required',
            ),
        array(
            'field' => 'patient_name',
            'label' => 'Nama Pasien',
            'rules' => 'required',
            ),
        array(
            'field' => 'patient_sex',
            'label' => 'Jenis Kelamin',
            'rules' => 'required',
            ),
        array(
            'field' => 'patient_dob',
            'label' => 'Tanggal Lahir',
            'rules' => 'required',
            ),
        array(
            'field' => 'address',
            'label' => 'Alamat',
            'rules' => '',
            ),
        array(
            'field' => 'phone_number',
            'label' => 'No. Telepon',
            'rules' => '',
            ),
        array(
            'field' => 'mobile_number',
            'label' => 'No. Telepon HP',
            'rules' => '',
            ),
        array(
            'field' => 'keluhan',
            'label' => 'Keluhan',
            'rules' => 'required',
            ),
        array(
            'field' => 'diagnosa',
            'label' => 'Diagnosa',
            'rules' => 'required',
            ),
        array(
            'field' => 'tindakan',
            'label' => 'Tindakan',
            'rules' => 'required',
            ),
        array(
            'field' => 'layanan_tambahan',
            'label' => 'Layanan Tambahan',
            'rules' => '',
            ),
        array(
            'field' => 'keterangan',
            'label' => 'Keterangan',
            'rules' => '',
            ),
        array(
            'field' => 'alergi_obat',
            'label' => 'Alergi Obat',
            'rules' => '',
            ),
        array(
            'field' => 'transaction_date',
            'label' => 'Tanggal Periksa',
            'rules' => 'required',
            ),
        array(
            'field' => 'doctor_id',
            'label' => 'Dokter',
            'rules' => 'required',
            ),
        array(
            'field' => 'biaya_medis',
            'label' => 'Biaya Periksa',
            'rules' => 'required',
            ),
    ),
    '/system/cashier/new' => array(
        array(
            'field' => 'anamnesis',
            'label' => 'No. Rekam Medis',
            'rules' => 'required',
            ),
        array(
            'field' => 'patient_name',
            'label' => 'Nama Pasien',
            'rules' => 'required',
            ),
        array(
            'field' => 'patient_sex',
            'label' => 'Jenis Kelamin',
            'rules' => 'required',
            ),
        array(
            'field' => 'patient_dob',
            'label' => 'Tanggal Lahir',
            'rules' => 'required',
            ),
        array(
            'field' => 'address',
            'label' => 'Alamat',
            'rules' => '',
            ),
        array(
            'field' => 'phone_number',
            'label' => 'No. Telepon',
            'rules' => '',
            ),
        array(
            'field' => 'mobile_number',
            'label' => 'No. Telepon HP',
            'rules' => '',
            ),
        array(
            'field' => 'transaction_date',
            'label' => 'Tanggal Periksa',
            'rules' => 'required',
            ),
        array(
            'field' => 'transaction_no',
            'label' => 'No. Transaksi',
            'rules' => 'required',
            ),
        array(
            'field' => 'doctor_id',
            'label' => 'Dokter',
            'rules' => 'required',
            ),
        array(
            'field' => 'payment_status',
            'label' => 'Status Pembayaran',
            'rules' => 'required',
            ),
        array(
            'field' => 'biaya_admin',
            'label' => 'Biaya Admin',
            'rules' => 'required',
            ),
        array(
            'field' => 'biaya_obat',
            'label' => 'Biaya Obat',
            'rules' => 'required',
            ),
        array(
            'field' => 'total_biaya',
            'label' => 'Total Biaya',
            'rules' => 'required',
            ),
        array(
            'field' => 'biaya_medis',
            'label' => 'Biaya Periksa',
            'rules' => 'required',
            ),
    ),
    '/system/cashier/cashier_edit' => array(
        array(
            'field' => 'payment_status',
            'label' => 'Status Pembayaran',
            'rules' => 'required',
            ),
        array(
            'field' => 'jumlah_uang',
            'label' => 'Jumlah Uang',
            'rules' => 'required',
            ),
        array(
            'field' => 'kembalian',
            'label' => 'Kembalian',
            'rules' => 'required',
            ),
    ),
    '/system/manage' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'required|callback__duplicate_checked',
            ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required',
            ),
        array(
            'field' => 'conf_password',
            'label' => 'Confirmation Password',
            'rules' => 'required|callback__conf_pass_checked',
            ),
        array(
            'field' => 'user_type',
            'label' => 'User Type',
            'rules' => 'required',
            ),
		array(
            'field' => 'type',
            'label' => 'Pages',
            'rules' => 'callback__admin_roles_checked'
        ),
    ),
    '/system/detail' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'required|callback__duplicate_edit_checked',
            ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => '',
            ),
        array(
            'field' => 'conf_password',
            'label' => 'Confirmation Password',
            'rules' => 'callback__conf_pass_checked',
            ),
        array(
            'field' => 'user_type',
            'label' => 'User Type',
            'rules' => 'required',
            ),
		array(
            'field' => 'type',
            'label' => 'Pages',
            'rules' => 'callback__admin_roles_checked'
        ),
    ),
    '/system/password' => array(
        array(
            'field' => 'old_password',
            'label' => 'Old Password',
            'rules' => 'required|callback__old_pass_checked',
            ),
        array(
            'field' => 'password',
            'label' => 'New Password',
            'rules' => 'required',
            ),
        array(
            'field' => 'conf_password',
            'label' => 'Confirmation Password',
            'rules' => 'required|callback__conf_pass_checked',
            ),
    ),
);
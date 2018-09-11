ALTER TABLE `dtb_transaction` ADD `jumlah_uang` INT(11) NULL DEFAULT '0' AFTER `total_biaya`, ADD `kembalian` INT(11) NULL DEFAULT '0' AFTER `jumlah_uang`;
INSERT INTO `dtb_pages` (`pages_id`, `status`, `name`, `link`, `category_id`, `bit`) VALUES ('7', '1', 'Pendapatan Dokter', 'system/report/income', '1', '2'), ('8', '1', 'Rekam Medis', 'system/report/anamnesis', '1', '4');

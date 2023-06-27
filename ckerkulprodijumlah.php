<?php
include '../koneksi.php';
session_start();
if ($_SESSION['status'] != "sudah_login") {
    header("location:../login.php");
} elseif ($_SESSION['level'] != "admin") {
    header("location:../user/index.php");
}
?>

<!doctype html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Data Analysis Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="assets/vendors/bootstrap/css/bootstrap.css">
    <!-- Style CSS (White)-->
    <link rel="stylesheet" href="assets/css/White.css">
    <!-- Style CSS (Dark)-->
    <link rel="stylesheet" href="assets/css/Dark.css">
    <!-- FontAwesome CSS-->
    <link rel="stylesheet" href="assets/vendors/fontawesome/css/all.css">
    <!-- Icon LineAwesome CSS-->
    <link rel="stylesheet" href="assets/vendors/lineawesome/css/line-awesome.min.css">
</head>

<body>
    <!--Topbar -->
    <div class="topbar transition">
        <div class="bars">
            <button type="button" class="btn transition" id="sidebar-toggle">
                <i class="las la-bars"></i>
            </button>
        </div>
        <div class="menu">

            <ul>

                <li>
                    <div class="theme-switch-wrapper">
                        <label class="theme-switch" for="checkbox">
                            <input type="checkbox" id="checkbox" title="Dark Or White" />
                            Dark Mode
                            <div class="slider round"></div>
                        </label>
                    </div>
                </li>

                <li>
                    <div class="dropdown">
                        <div class="dropdown-toggle" id="dropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span><?php echo $_SESSION['nama']; ?></span>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="dropdownProfile">
                            <a class="dropdown-item" href="../logout.php">
                                <i class="las la-sign-out-alt mr-2"></i> Sign Out
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!--Sidebar-->
    <div class="sidebar transition overlay-scrollbars">
        <div class="logo">
            <h2 style="font-weight: 700;" class="mb-0"><span style="font-weight: 500;">Admin</span></h2>
        </div>

        <div class="sidebar-items">
            <div class="accordion" id="sidebar-items">
                <ul>

                    <p class="menu">Apps</p>

                    <li>
                        <a href="index.php" class="items">
                            <i class="fa fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>


                    <p class="menu">Admin Menu</p>

                    <li id="headingTwo">
                        <a href="onclick();" class="submenu-items" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            <i class="fas la-wrench"></i>
                            <span>Abilities</span>
                            <i class="fas la-angle-right"></i>
                        </a>
                    </li>
                    <div id="collapseTwo" class="collapse submenu" aria-labelledby="headingTwo" data-parent="#sidebar-items">
                        <ul>

                            <li>
                                <a href="profileadjust/authlevels.php">Authorization Levels</a>
                            </li>
                            <li>
                                <a href="profileadjust/approval.php">User Permissions</a>
                            </li>

                        </ul>
                    </div>

                    <p class="menu">Pages</p>

                    <li id="headingThree">
                        <a href="onclick();" class="submenu-items" data-toggle="collapse" data-target="#collapsefour" aria-expanded="true" aria-controls="collapsefour">
                            <i class="fas la-cog"></i>
                            <span>Tables</span>
                            <i class="fas la-angle-right"></i>
                        </a>
                    </li>
                    <div id="collapsefour" class="collapse submenu" aria-labelledby="headingThree" data-parent="#sidebar-items">
                        <ul>

                            <li>
                                <a href="kerja.php">Kerja</a>
                            </li>

                            <li>
                                <a href="kerjakuliah.php">Kerja dan Kuliah</a>
                            </li>

                            <li>
                                <a href="kuliah.php">Kuliah</a>
                            </li>

                            <li>
                                <a href="mencrkrj.php">Mencari Kerja</a>
                            </li>

                            <li>
                                <a href="usaha.php">Usaha</a>
                            </li>

                            <li>
                                <a href="search.php">Cari Data</a>
                            </li>

                        </ul>
                    </div>



                    <li id="headingFour">
                        <a href="onclick();" class="submenu-items" data-toggle="collapse" data-target="#collapseChart" aria-expanded="true" aria-controls="collapseChart">
                            <i class="fas la-chart-pie"></i>
                            <span>Charts</span>
                            <i class="fas la-angle-right"></i>
                        </a>
                    </li>
                    <div id="collapseChart" class="collapse submenu" aria-labelledby="headingFour" data-parent="#sidebar-items">
                        <ul>
                            <!-- Chart di dalam tabel kerja -->
                            <li>
                                <p>Kerja</p>
                            </li>
                            <li>
                                <a href="chartjumlahtahunkerja.php">Total Tahun Masuk Kerja</a>
                            </li>

                            <!-- Chart di dalam tabel Kerja dan Kuliah -->
                            <li>
                                <p>Kerja dan Kuliah</p>
                            </li>
                            <li>
                                <a href="">Kerja dan Kuliah</a>
                            </li>
                        </ul>
                    </div>

            </div>
        </div>
    </div>

    <div class="sidebar-overlay"></div>

    <!-- Penempatan Chart -->
    <div style="padding-left: 300px; padding-top: 100px;">
        <center>
            <h4>Pie Chart - Alumni UPN "Veteran" Jawa Timur</h4>
            <canvas id="piechart" class="canvas-container "></canvas>
        </center>
    </div>

    <style>
        .canvas-container {
            width: auto;
            height: 150px;
        }
    </style>

    <!-- Pemanggilan data untuk dibuat chart -->
    <?php
    // // Ambil data dari database
    // $koneksi = mysqli_connect("localhost", "root", "", "sistem_informasi_alumni");
    // $query = mysqli_query($koneksi, "SELECT nama_perusahaan, COUNT(*) as jumlah_orang FROM kuliahkerja GROUP BY nama_perusahaan");
    // $data = $query('nama_perusahaan');

    // // Mengambil nilai dari kolom-kolom yang diperlukan
    // $labels = array_column($data, 'nama_perusahaan');

    // // Menghitung total jumlah tahun kerja per nama_perusahaan
    // $dataKerjaKuliah = array();
    // foreach ($data as $row) {
    //     if (!isset($dataKerjaKuliah[$row['nama_perusahaan']])) {
    //         $dataKerjaKuliah[$row['nama_perusahaan']] = 0;
    //     }
    //     $dataKerjaKuliah[$row['nama_perusahaan']] = $row['jumlah'];
    // }

    // // Mengambil data total tahun kerja
    // $dataKerjaKuliah = array_values($dataKerjaKuliah);

    ?>
    <!-- 
    <script>
        var ctx = document.getElementById('chart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Total Tahun Kerja',
                    data: <?php echo json_encode($dataKerjaKuliah); ?>,
                    backgroundColor: 'green',
                    borderColor: 'lightgreen',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    </script> -->



    <?php
    // $data = mysqli_query($koneksi, "select nama_perusahaan, COUNT(*) from kerjakuliah GROUP BY nama_perusahaan");
    // while ($row = mysqli_fetch_array($data)) {
    //     $nama_produk[] = $row[];

    //     $query = mysqli_query($koneksi, "select activecases from tb_covid19 where id_covid='" . $row['id_covid'] . "'");
    //     $row = $query->fetch_array();
    //     $jumlah_produk[] = $row['activecases'];
    // }
    ?>

    <script>
        // var config = {
        //     type: 'pie',
        //     data: {
        //         datasets: [{
        //             data: <?php echo json_encode($jumlah_produk); ?>,
        //             backgroundColor: [
        //                 'rgba(255, 99, 132, 0.2)',
        //                 'rgba(54, 162, 235, 0.2)',
        //                 'rgba(255, 206, 86, 0.2)',
        //                 'rgba(75, 192, 192, 0.2)',
        //                 'rgba(255, 159, 64, 0.2)',
        //             ],
        //             borderColor: [
        //                 'rgba(255, 99, 132, 1)',
        //                 'rgba(54, 162, 235, 1)',
        //                 'rgba(255, 206, 86, 1)',
        //                 'rgba(75, 192, 192, 1)',
        //                 'rgba(255, 159, 64, 1)',
        //             ],
        //             label: 'Total Cases'
        //         }],
        //         labels: <?php echo json_encode($nama_produk); ?>
        //     },
        //     options: {
        //         responsive: true
        //     }
        // };

        // window.onload = function() {
        //     var ctx = document.getElementById('chart-area').getContext('2d');
        //     window.myPie = new Chart(ctx, config);
        // };

        // document.getElementById('randomizeData').addEventListener('click', function() {
        //     config.data.datasets.forEach(function(dataset) {
        //         dataset.data = dataset.data.map(function() {
        //             return randomScalingFactor();
        //         });
        //     });

        //     window.myPie.update();
        // });

        // var colorNames = Object.keys(window.chartColors);
        // document.getElementById('addDataset').addEventListener('click', function() {
        //     var newDataset = {
        //         backgroundColor: [],
        //         data: [],
        //         label: 'New dataset ' + config.data.datasets.length,
        //     };

        //     for (var index = 0; index < config.data.labels.length; ++index) {
        //         newDataset.data.push(randomScalingFactor());

        //         var colorName = colorNames[index % colorNames.length];
        //         var newColor = window.chartColors[colorName];
        //         newDataset.backgroundColor.push(newColor);
        //     }

        //     config.data.datasets.push(newDataset);
        //     window.myPie.update();
        // });

        // document.getElementById('removeDataset').addEventListener('click', function() {
        //     config.data.datasets.splice(0, 1);
        //     window.myPie.update();
        // });
    </script>

    <?php
    // Query untuk mengambil data nama perusahaan dan menghitung jumlah orang
    $query = mysqli_query($koneksi, "SELECT nama_perusahaan, COUNT(*) as jumlah_orang FROM kerjakuliah GROUP BY nama_perusahaan");
    $data = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
    }
    ?>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Nama Perusahaan');
            data.addColumn('number', 'Jumlah Orang');

            // Menambahkan data ke dalam DataTable
            <?php
            foreach ($data as $row) {
                echo "data.addRow(['" . $row['nama_perusahaan'] . "', " . $row['jumlah_orang'] . "]);";
            }
            ?>

            var options = {
                title: 'Pie Chart Nama Perusahaan dan Jumlah Orang',
                is3D: true,
                // Tambahan opsi lainnya sesuai kebutuhan Anda
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>

</body>

<!-- Library Javascipt-->
<script src="assets/vendors/bootstrap/js/jquery.min.js"></script>
<script src="assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendors/bootstrap/js/popper.min.js"></script>
<script src="assets/js/script.js"></script>
<div class="sidebar-overlay"></div>

</html>
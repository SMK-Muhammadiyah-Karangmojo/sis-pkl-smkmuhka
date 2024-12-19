<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.my.id/
 */
echo $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card card-outline-tabs card-info">
    <div class="card-header">Informasi Semua Presensi</div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_length" id="dataTable_length">
                    <label>Show
                        <select name="dataTable_length"
                                aria-controls="dataTable"
                                class="custom-select custom-select-sm form-control form-control-sm">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        entries
                    </label>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div id="dataTable_filter" class="dataTables_filter">
                    <label>Search:
                        <input type="search"
                               class="form-control form-control-sm"
                               placeholder=""
                               aria-controls="dataTable"
                               id="searchInput">
                    </label>
                    <button id="searchButton" class="btn btn-sm btn-primary">Search</button>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-striped mt-3 mb-3">
            <thead>
            <tr class="text-center table-primary">
                <th rowspan="2">No</th>
                <th rowspan="2">Nama Siswa</th>
                <th rowspan="2">Kelas</th>
                <th colspan="3">Presensi</th>
                <th rowspan="2">Action</th>
            </tr>
            <tr class="text-center table-primary">
                <th>Tanggal</th>
                <th>Masuk</th>
                <th>Pulang</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="7" class="text-center">Loading...</td>
            </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col-sm-12 col-md-5">
                <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite"></div>
            </div>
            <div class="col-sm-12 col-md-7">
                <div class="dataTables_paginate paging_simple_numbers" id="pagination">
                    <ul class="pagination"></ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const apiUrl = "<?= base_url('/api/v1/presence/findAll'); ?>"; // Endpoint API
    let currentPage = 1;
    let totalPage = 0;

    async function fetchData(page, searchTerm = '') {
        // Contoh URL dengan query parameter untuk pencarian dan halaman
        const url = `/api/v1/presence/findAll?offset=${page}&search=${encodeURIComponent(searchTerm)}`;
        try {
            fetch(url)
                .then(response => response.json())
                .then(result => {
                    console.log(result)
                    if (result.responseData.code === 200) {
                        renderTable(result.result);
                        totalPage = result.metaData.totalPage;
                        renderPagination(totalPage, page);
                    } else {
                        console.error('Failed to fetch data:', result.responseData.message);
                    }
                })
                .catch(error => console.error('Error fetching data:', error));

            // const response = await fetch(`${url}`);
            // const result = await response.json();
            //
            // if (result.responseData.code === 200) {
            //     renderTable(result.result);
            //     totalPage = result.metaData.totalPage;
            //     renderPagination(totalPage, page);
            // } else {
            //     console.error('Failed to fetch data:', result.responseData.message);
            // }
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    function renderTable(data) {
        const tableBody = document.querySelector('tbody');
        tableBody.innerHTML = '';

        if (data.length > 0) {
            data.forEach((item, index) => {
                const row = `
                <tr>
                    <td>${index + 1 + (currentPage - 1) * 10}</td>
                    <td>${item.name}</td>
                    <td>${item.class}</td>
                    <td>${new Date(item.date).toLocaleDateString()}</td>
                    <td class="text-center">${item.time_in || '-'}</td>
                    <td class="text-center">${item.time_out || '-'}</td>
                    <td class="text-center">
                        <a href="<?= base_url('/presence/detail/'); ?>${item.id}">
                            <button class="btn btn-sm btn-primary">Detail</button>
                        </a>
                    </td>
                </tr>`;
                tableBody.insertAdjacentHTML('beforeend', row);
            });
        } else {
            tableBody.innerHTML = '<tr><td colspan="7" class="text-center">Data tidak ditemukan</td></tr>';
        }
    }

    function renderTableInfo(currentPage, limit, totalData) {
        const dataTableInfo = document.getElementById('dataTable_info');

        // Calculate start and end entries
        const startEntry = (currentPage - 1) * limit + 1;
        const endEntry = Math.min(currentPage * limit, totalData);

        // Update the information text
        dataTableInfo.textContent = `Showing ${startEntry} to ${endEntry} of ${totalData} entries`;
    }

    function renderPagination(totalPages, currentPage) {
        const paginationElement = document.querySelector('#pagination ul');
        paginationElement.innerHTML = '';

        // Previous Button
        const prevClass = currentPage === 1 ? 'disabled' : '';
        paginationElement.insertAdjacentHTML('beforeend', `
        <li class="paginate_button page-item ${prevClass}">
            <a href="#" class="page-link" data-page="${currentPage - 1}">Previous</a>
        </li>
    `);

        // Calculate range of pages to display (currentPage - 1, currentPage, currentPage + 1)
        const startPage = Math.max(1, currentPage - 1);
        const endPage = Math.min(totalPages, currentPage + 1);

        for (let i = startPage; i <= endPage; i++) {
            const activeClass = i === currentPage ? 'active' : '';
            paginationElement.insertAdjacentHTML('beforeend', `
            <li class="paginate_button page-item ${activeClass}">
                <a href="#" class="page-link" data-page="${i}">${i}</a>
            </li>
        `);
        }

        // Next Button
        const nextClass = currentPage === totalPages ? 'disabled' : '';
        paginationElement.insertAdjacentHTML('beforeend', `
        <li class="paginate_button page-item ${nextClass}">
            <a href="#" class="page-link" data-page="${currentPage + 1}">Next</a>
        </li>
    `);

        // Add Event Listeners to Pagination Links
        document.querySelectorAll('.page-link').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const page = parseInt(link.getAttribute('data-page'));
                if (!isNaN(page) && page > 0 && page <= totalPages) {
                    currentPage = page;
                    fetchData(currentPage);
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', () => fetchData(currentPage));

    // document.getElementById("search").addEventListener("keyup", function () {
    //     const query = this.value.toLowerCase();
    //     const rows = document.querySelectorAll('tbody tr');
    //
    //     rows.forEach(row => {
    //         const cells = row.querySelectorAll('td');
    //         const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(query));
    //         row.style.display = match ? '' : 'none';
    //     });
    // });
    document.querySelector('#searchInput').addEventListener('click', async (e) => {
        e.preventDefault();
        const searchTerm = document.querySelector('#searchInput').value;

        // Reset current page to 1
        const currentPage = 1;

        // Fetch data for the search term starting from page 1
        await fetchData(currentPage, searchTerm);
    });
</script>
<?= $this->endSection() ?>


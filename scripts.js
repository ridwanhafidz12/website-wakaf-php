document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    const pemasukanTable = document.getElementById('pemasukan-table').getElementsByTagName('tbody')[0];
    
    function filterTable(table, filterText) {
        const rows = table.getElementsByTagName('tr');
        for (let row of rows) {
            const cells = row.getElementsByTagName('td');
            let match = false;
            for (let cell of cells) {
                if (cell.textContent.toLowerCase().includes(filterText)) {
                    match = true;
                    break;
                }
            }
            row.style.display = match ? '' : 'none';
        }
    }
    
    searchInput.addEventListener('input', () => {
        const filterText = searchInput.value.toLowerCase();
        filterTable(pemasukanTable, filterText);
    });
    

    // Pagination
    function paginateTable(table, itemsPerPage, paginationControlsId) {
        const rows = table.getElementsByTagName('tr');
        const totalPages = Math.ceil(rows.length / itemsPerPage);
        const paginationControls = document.getElementById(paginationControlsId);

        let currentPage = 1;

        function showPage(page) {
            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;

            for (let i = 0; i < rows.length; i++) {
                rows[i].style.display = (i >= start && i < end) ? '' : 'none';
            }

            currentPage = page;
            updatePaginationControls();
        }

        function updatePaginationControls() {
            paginationControls.innerHTML = '';
            const prevBtn = document.createElement('button');
            prevBtn.textContent = '«';
            prevBtn.className = 'pagination-button' + (currentPage === 1 ? ' disabled' : '');
            prevBtn.addEventListener('click', () => {
                if (currentPage > 1) showPage(currentPage - 1);
            });
            paginationControls.appendChild(prevBtn);

            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.textContent = i;
                btn.className = 'pagination-button' + (i === currentPage ? ' active' : '');
                btn.addEventListener('click', () => showPage(i));
                paginationControls.appendChild(btn);
            }

            const nextBtn = document.createElement('button');
            nextBtn.textContent = '»';
            nextBtn.className = 'pagination-button' + (currentPage === totalPages ? ' disabled' : '');
            nextBtn.addEventListener('click', () => {
                if (currentPage < totalPages) showPage(currentPage + 1);
            });
            paginationControls.appendChild(nextBtn);
        }

        showPage(1);
    }

    paginateTable(pemasukanTable, 15, 'pemasukan-pagination-controls');
    paginateTable(pengeluaranTable, 15, 'pengeluaran-pagination-controls');

    // Download PDF
    document.getElementById('download-pdf').addEventListener('click', () => {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        const month = document.getElementById('month').value;
        const pemasukanRows = Array.from(pemasukanTable.getElementsByTagName('tr')).filter(row => row.querySelector('td:last-child').textContent.includes(month));
        const pengeluaranRows = Array.from(pengeluaranTable.getElementsByTagName('tr')).filter(row => row.querySelector('td:last-child').textContent.includes(month));

        if (pemasukanRows.length === 0 && pengeluaranRows.length === 0) {
            alert('No data available for the selected month.');
            return;
        }

        doc.text('Laporan Donasi - Bulan ' + month, 10, 10);

        if (pemasukanRows.length > 0) {
            doc.text('Pemasukan', 10, 20);
            doc.autoTable({
                startY: 25,
                head: [['ID', 'Nama', 'Jumlah', 'Program', 'Bulan']],
                body: pemasukanRows.map(row => Array.from(row.getElementsByTagName('td')).map(cell => cell.textContent))
            });
        }

        if (pengeluaranRows.length > 0) {
            const startY = doc.autoTable.previous.finalY + 10;
            doc.text('Pengeluaran', 10, startY);
            doc.autoTable({
                startY: startY + 5,
                head: [['ID', 'Nama', 'Jumlah', 'Program', 'Keterangan', 'Bulan']],
                body: pengeluaranRows.map(row => Array.from(row.getElementsByTagName('td')).map(cell => cell.textContent))
            });
        }

        doc.save('Laporan Donasi Bulan ' + month + '.pdf');
    });
    
    
});



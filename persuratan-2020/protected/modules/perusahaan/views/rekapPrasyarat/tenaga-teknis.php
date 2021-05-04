   
<link rel="stylesheet" type="text/css" href="<?=Yii::app()->createUrl('/js');?>orbjs/dist/orb.css" />
<script type="text/javascript" src="<?=Yii::app()->createUrl('/js');?>orbjs/deps/react-0.12.2.js"></script>
<script type="text/javascript" src="<?=Yii::app()->createUrl('/js');?>orbjs/dist/orb.js"></script>	
	<!-- ***** -->

   <style type="text/css">
    div#rr{        
        font-size: 13px;
    }
    
    div#rr td{
        padding: 5px;
    }
    
    div#rr td.header div{
        text-align: center;
    }
    
    div#rr th{
        text-align: center;
    }
    
    </style>

    <h4 style="margin-top: 2em; text-align: center">Rekapitulasi Organisasi &AMP; Tenaga Kerja Periode RKT <?=$tahun;?></h4>
    <div id="rr" style="padding: 7px;"></div>
    <div id="export" style="padding: 7px;"></div>

<script type="text/javascript">


    function exportToExcel(anchor) {
        anchor.href = orb.export(pgridwidget);
        return true;
    }
    
    var jsonData = <?=$model;?>;
    var config = {
        dataSource: jsonData,
        canMoveFields: true, 
        dataHeadersLocation: 'columns',
        //width: 1099,
        //height: 611,
        theme: 'blue',
        toolbar: {
            visible: true
        },
        grandTotal: {
            rowsvisible: true,
            columnsvisible: false
        },
        subTotal: {
            visible: true,
            collapsed: false,
            collapsible: true
        },
        rowSettings: {
            subTotal: {
                visible: true,
                collapsed: false,
                collapsible: true
            }
        },
        columnSettings: {
            subTotal: {
                visible: true,
                collapsed: false,
                collapsible: true
            }
        },
        fields: [
            {
                name: 'realisasi',
                caption: 'Realisasi',
                dataSettings: {
                    aggregateFunc: 'sum',
                    aggregateFuncName: 'sum',
                    formatFunc: function(value) {
                        return value ? Number(value).toLocaleString() : '0';
                    }
                }
            },
            {
                name: 'persentase',
                caption: '(%)',
                dataSettings: {
                    aggregateFunc: 'sum',
                    aggregateFuncName: 'sum',
                    formatFunc: function(value) {
                        return value ? Number(value).toLocaleString() : '0';
                    }
                }
            },            
            {
                name: 'jenis_rencana',
                caption: 'Tenaga Teknis - Rencana (Org)',
                sort: {
                    order: 'asc'
                },
                rowSettings: {
                    subTotal: {
                        visible: true,
                        collapsed: false,
                        collapsible: true
                    }
                }
            },            
            /*{
                name: 'tahun',
                caption: 'Tahun'
            },
            {
                name: 'bulan',
                caption: 'Bulan',
            },*/
            {
                name: 'periode',
                caption: 'Periode',
            },
            {
                name: 'nama_jenis',
                caption: 'Tenaga Teknis',
            }                        
        ],
        rows    : ['periode'],//, 'Category' ],
        columns : ['jenis_rencana'],
        data    : ['realisasi', 'persentase' ],
        /*preFilters : {
            'Class': { 'Matches': 'Regular' },
            'Manufacturer': { 'Matches': /^a|^c/ },
            'Category'    : { 'Does Not Match': 'D' },
           // 'Amount'      : { '>':  40 },
         //   'Quantity'    : [4, 8, 12]
        }*/
    };

    var elem = document.getElementById('rr')

    var pgridwidget = new orb.pgridwidget(config);
    pgridwidget.render(elem);

    </script>
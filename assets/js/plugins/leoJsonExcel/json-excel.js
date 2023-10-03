const dataTest = [{
    "Alumno": "erick Juan Juan",
    "boleta": "98745632",
    "rol": "Egresado",
    "electiva": 17,
},
{
    "Alumno": "Poa Poa Poa",
    "boleta": "98745789",
    "rol": "Egresado",
    "electiva": 10,
},
{
    "Alumno": "dante dante dante",
    "boleta": "987789777",
    "rol": "Alumno",
    "electiva": 1,
},
{
    "Alumno": "Yanay Yanay Yanay",
    "boleta": "9888887",
    "rol": "Alumno",
    "electiva": 5,
}
];
// console.log(JSON.stringify(dataTest, undefined, 4));
// document.getElementById("json").innerHTML = JSON.stringify(dataTest, undefined, 4);


const EXCEL_TYPE = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8';
const EXCEL_EXTENSION = '.xlsx';

function downloadExcel(jsonData,fileName){
    const worksheet = XLSX.utils.json_to_sheet(jsonData);
    const workbook = 
    {
        Sheets:
        {
            'data':worksheet
        },
        SheetNames:['data']
    };
    const excelBuffer = XLSX.write(workbook,{bookType:'xlsx',type:'array'})
    //// console.log(excelBuffer);
    saveAsExcel(excelBuffer,fileName);
}

function saveAsExcel(excelBuffer,fileName){
    const data = new Blob([excelBuffer],{type:EXCEL_TYPE});
    saveAs(data,fileName+'_export_'+EXCEL_EXTENSION);
}

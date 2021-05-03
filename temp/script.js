window.onload = function(){
    var image = document.getElementById("image");
    image.addEventListener("mousedown", makeGrid );
    image.addEventListener("mousemove", resizeGrid );
    image.addEventListener("mouseup", fillGrid );
    
    var coordArray =[[],[]];
    var origin =    [];
    var moveOrigin =[];
    var isDown =    false;
    var selected = false;
    var showArr = document.getElementById("showArray");
    showArr.addEventListener("click", showArray );

    

/*ОГОНЬ С ГРИДОМ*/   
function makeGrid(e){
    image.innerHTML = "";
    isDown = true;
    origin[0] = e.pageX;
    origin[1] = e.pageY;
//    
    var grid = document.createElement("div");
    grid.id = "grid";
    grid.style.position = "absolute";
    grid.style.top =    e.pageY+"px";
    grid.style.left =   e.pageX+"px";
    grid.style.width =  "1px";
    grid.style.height = "1px";
    grid.style.boxShadow = "0px 0px 0px 2px rgba(255,0,0,1)";
    grid.style.background = "rgba(255,200,200,0.2)";
    grid.style.display = "flex";
    grid.style.flexDirection = "column";
    image.appendChild(grid);
}

function resizeGrid(e){
    if(isDown && !selected){
        var pos = document.getElementById("position");
        var size = document.getElementById("grid-size");
        var grid = document.getElementById("grid");
        var newWidth =  e.pageX-origin[0];
        var newHeight = e.pageY-origin[1];
        grid.style.width =  newWidth+"px";
        grid.style.height = newHeight+"px";
        size.innerHTML = `width:${newWidth} height:${newHeight}`; 
        pos.innerHTML = `X:${e.pageX} Y:${e.pageY}`; 
    }
    else if(selected&&isDown){
        
    }
}

function fillGrid(){
        isDown = false;
        var col = document.getElementById("col").value;
        var row = document.getElementById("row").value;
        var grid = document.getElementById("grid");
        var gridW = grid.offsetWidth;
        var gridH = grid.offsetHeight;
        
    if(gridW>50 && gridH>50){    
        for(var i=0; i<row; i++){
                var elementContainer = document.createElement('div');
                elementContainer.style.width = "100%";
                elementContainer.style.height = `calc(100% / ${row})`;
                elementContainer.style.display = "flex";
                elementContainer.style.flexDirection = "row";
                elementContainer.style.justifyContent = "space-between";
            for(var j=0; j<col;j++){
                var gridElement = document.createElement('div');
                gridElement.style.width = `calc(100% / ${col} - 2px)`;
                gridElement.style.height = `calc(100% - 2px)`;
                gridElement.style.border = "1px solid transparent";
                gridElement.style.background = "rgba(255,250,230,0.2)";
                elementContainer.appendChild(gridElement);
            }
            grid.appendChild(elementContainer);
        }
    }
    grid.style.cursor = "pointer";
    grid.addEventListener("mousedown", mouseDownGrid );
    grid.addEventListener("mousemove", mouseMoveGrid );
    grid.addEventListener("mouseup", mouseUpGrid );
}

function mouseDownGrid(e){
    e.stopPropagation();
    selected = true;
    isDown = true;
    var grid = document.getElementById("grid");
    grid.style.cursor = "move";
    moveOrigin[0] = e.pageX-parseInt(grid.style.left);
    moveOrigin[1] = e.pageY-parseInt(grid.style.top);
}
function mouseMoveGrid(e){
    if(selected && isDown){
    var grid = document.getElementById("grid");
    var x = e.pageX-moveOrigin[0];
    var y = e.pageY-moveOrigin[1];
    grid.style.left = x+"px";
    grid.style.top = y+"px";
    }
}
function mouseUpGrid(e){
    e.stopPropagation();
    isDown = false;
    selected = false;
    var grid = document.getElementById("grid");
    grid.style.cursor = "pointer";
}


/*ЖАРА С МАССИВОМ*/
    function showArray(){
        //alert("X:"+coordArray[0]+"; Y:"+coordArray[1]);
        var grid =document.getElementById("grid");
        if(grid){
            var x,y,imageX,imageY,gridX,gridY;
            var image = document.getElementById("image");
            imageX = image.offsetWidth;
            imageY = image.offsetHeight;
            gridX = parseInt(grid.style.left);
            gridY = parseInt(grid.style.top);
            x = gridX/(imageX/100);
            y = gridY/(imageY/100);
            gridW = grid.offsetWidth;
            gridH = grid.offsetHeight
            alert(`gridW:${gridW},gridH:${gridH}, posX%:${x},posY%:${y}`);
        }
    }
}
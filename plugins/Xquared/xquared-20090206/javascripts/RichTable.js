/**
 * @requires Xquared.js
 * @requires rdom/Base.js
 */
xq.RichTable = xq.Class(/** @lends xq.RichTable.prototype */{
	/**
	 * TODO: Add description
	 *
	 * @constructs
	 */
	initialize: function(rdom, table) {
		xq.addToFinalizeQueue(this);

		this.rdom = rdom;
		this.table = table;
	},
	collectCells: function(cell){
		var cells = [];
		var x = this.getXIndexOf(cell);
		var y = 0;
		while(true) {
			var cur = this.getCellAt(x, y);
			if(!cur) break;
			cells.push(cur);
			y++;
		}
		
		return cells
	},
	insertNewRowAt: function(tr, where) {
		var row = this.rdom.createElement("TR");
		var cells = tr.cells;
		for(var i = 0; i < cells.length; i++) {
			var cell = this.rdom.createElement(cells[i].nodeName);
			this.rdom.correctEmptyElement(cell);
			row.appendChild(cell);
		}
		return this.rdom.insertNodeAt(row, tr, where);
	},
	insertNewCellAt: function(cell, where) {
		var cells = this.collectCells(cell);
		
		// insert new cells
		for(var i = 0; i < cells.length; i++) {
			var cell = this.rdom.createElement(cells[i].nodeName);
			this.rdom.correctEmptyElement(cell);
			this.rdom.insertNodeAt(cell, cells[i], where);
		}
	},
	
	deleteTable: function(table) {
		return this.rdom.deleteNode(table);
	},
	deleteRow: function(tr) {
		return this.rdom.removeBlock(tr);
	},
	deleteCell: function(cell) {
		if(!cell.previousSibling && !cell.nextSibling) {
			this.rdom.deleteNode(this.table);
			return;
		}
		
		var cells = this.collectCells(cell);
		
		for(var i = 0; i < cells.length; i++) {
			this.rdom.deleteNode(cells[i]);
		}
	},
	getPreviousCellOf: function(cell) {
		if(cell.previousSibling) return cell.previousSibling;
		var adjRow = this.getPreviousRowOf(cell.parentNode);
		if(adjRow) return adjRow.lastChild;
		return null;
	},
	getNextCellOf: function(cell) {
		if(cell.nextSibling) return cell.nextSibling;
		var adjRow = this.getNextRowOf(cell.parentNode);
		if(adjRow) return adjRow.firstChild;
		return null;
	},
	getPreviousRowOf: function(row) {
		if(row.previousSibling) return row.previousSibling;
		var rowContainer = row.parentNode;
		if(rowContainer.previousSibling && rowContainer.previousSibling.lastChild) return rowContainer.previousSibling.lastChild;
		return null;
	},
	getNextRowOf: function(row) {
		if(row.nextSibling) return row.nextSibling;
		var rowContainer = row.parentNode;
		if(rowContainer.nextSibling && rowContainer.nextSibling.firstChild) return rowContainer.nextSibling.firstChild;
		return null;
	},
	getAboveCellOf: function(cell) {
		var row = this.getPreviousRowOf(cell.parentNode);
		if(!row) return null;
		
		var x = this.getXIndexOf(cell);
		return row.cells[x];
	},
	getBelowCellOf: function(cell) {
		var row = this.getNextRowOf(cell.parentNode);
		if(!row) return null;
		
		var x = this.getXIndexOf(cell);
		return row.cells[x];
	},
	getXIndexOf: function(cell) {
		var row = cell.parentNode;
		for(var i = 0; i < row.cells.length; i++) {
			if(row.cells[i] === cell) return i;
		}
		
		return -1;
	},
	getYIndexOf: function(cell) {
		var y = -1;
		
		// find y
		var group = row.parentNode;
		for(var i = 0; i <group.rows.length; i++) {
			if(group.rows[i] === row) {
				y = i;
				break;
			}
		}
		if(this.hasHeadingAtTop() && group.nodeName === "TBODY") y = y + 1;
		
		return y;
	},


	getTableProperty: function() {
		var prop = {
			width: this.table.style.width || 'auto',
			height: this.table.style.height || 'auto',
			textAlign: this.table.style.textAlign || '',
			borderColor: this.table.style.borderLeftColor || '',
			borderWidth: this.table.style.borderLeftWidth.replace(/ .*/, '').replace(/[^0-9]/g, '') || '0',
			backgroundColor: this.table.style.backgroundColor || 'transparent'
		};
		return prop;
	},
	setTableProperty: function(prop) {
		this._setTableProperty(this.table, prop);
	},
	getRowProperty: function(row) {
		var prop = {
			height: row.style.height || 'auto',
			verticalAlign: row.style.verticalAlign || '',
			textAlign: row.style.textAlign || '',
			backgroundColor: row.style.backgroundColor || 'transparent'
		};
		return prop;
	},
	setRowProperty: function(tr, prop) {
		this._setTableProperty(tr, prop);
	},
	getColumnProperty: function(cell) {
		var prop = {
			width: cell.style.width || 'auto',
			verticalAlign: cell.style.verticalAlign || '',
			textAlign: cell.style.textAlign || '',
			backgroundColor: cell.style.backgroundColor || 'transparent'
		};
		return prop;
	},
	setColumnProperty: function(cell, prop) {
		for (var i=0; i < cell.offsetParent.rows.length; i++) {
			this._setTableProperty(cell.offsetParent.rows[i].cells[cell.cellIndex], prop);
		}
	},

	_setTableProperty: function(el, prop) {
		if (typeof prop.width != 'undefined'){
			el.style.width = (typeof prop.width == 'string' ? prop.width : prop.width.size+prop.width.unit) || '';
		}
		if (typeof prop.height != 'undefined'){
			el.style.height = (typeof prop.height == 'string' ? prop.height : prop.height.size+prop.height.unit) || '';
		}
		if (typeof prop.textAlign != 'undefined'){
			el.style.textAlign = prop.textAlign || '';
		}
		if (typeof prop.verticalAlign != 'undefined'){
			el.style.verticalAlign = prop.verticalAlign || '';
		}
		if (typeof prop.borderColor != 'undefined'){
			el.style.borderColor = prop.borderColor || '';
		}
		if (typeof prop.borderWidth != 'undefined') {
			el.style.borderWidth = prop.borderWidth+'px' || '';
			if (prop.borderWidth > 0){
				el.style.borderStyle='solid';
			}
		}
		if (typeof prop.fixed != 'undefined') {
			el.style.tableLayout = 'fixed'
		}
		if (typeof prop.backgroundColor != 'undefined'){
			el.style.backgroundColor = prop.backgroundColor || '';
		}
		if (typeof prop.className != 'undefined'){
			el.className = prop.className || '';
		}
	},

	
	/**
	 * TODO: Not used. Delete or not?
	 */
	getLocationOf: function(cell) {
		var x = this.getXIndexOf(cell);
		var y = this.getYIndexOf(cell);
		return {x:x, y:y};
	},
	getCellAt: function(col, row) {
		var row = this.getRowAt(row);
		return (row && row.cells.length > col) ? row.cells[col] : null;
	},
	getRowAt: function(index) {
		if(this.hasHeadingAtTop()) {
			return index === 0 ? this.table.tHead.rows[0] : this.table.tBodies[0].rows[index - 1];
		} else {
			var rows = this.table.tBodies[0].rows;
			return (rows.length > index) ? rows[index] : null;
		}
	},
	getDom: function() {
		return this.table;
	},
	hasHeadingAtTop: function() {
		return !!(this.table.tHead && this.table.tHead.rows[0]);
	},
	hasHeadingAtLeft: function() {
		return this.table.tBodies[0].rows[0].cells[0].nodeName === "TH";
	},
	correctEmptyCells: function() {
		var cells = xq.$A(this.table.getElementsByTagName("TH"));
		var tds = xq.$A(this.table.getElementsByTagName("TD"));
		for(var i = 0; i < tds.length; i++) {
			cells.push(tds[i]);
		}
		
		for(var i = 0; i < cells.length; i++) {
			if(this.rdom.isEmptyBlock(cells[i])) this.rdom.correctEmptyElement(cells[i])
		}
	}
});

xq.RichTable.create = function(rdom, attrs) {
	if(["t", "tl", "lt"].indexOf(attrs.headerPositions) !== -1) var headingAtTop = true
	if(["l", "tl", "lt"].indexOf(attrs.headerPositions) !== -1) var headingAtLeft = true

	var sb = []
	sb.push('<table class="datatable2" style="width:100%;">')
	
	// thead
	if(headingAtTop) {
		sb.push('<thead><tr>')
		for(var i = 0; i < attrs.cols; i++) sb.push('<th></th>')
		sb.push('</tr></thead>')
		attrs.rows -= 1
	}
		
	// tbody
	sb.push('<tbody>')
	for(var i = 0; i < attrs.rows; i++) {
		sb.push('<tr>')
		
		for(var j = 0; j < attrs.cols; j++) {
			if(headingAtLeft && j === 0) {
				sb.push('<th></th>')
			} else {
				sb.push('<td></td>')
			}
		}
		
		sb.push('</tr>')
	}
	sb.push('</tbody>')
	
	sb.push('</table>')
	
	// create DOM element
	var container = rdom.createElement("div");
	container.innerHTML = sb.join("");
	
	// correct empty cells and return
	var rtable = new xq.RichTable(rdom, container.firstChild);
	rtable.correctEmptyCells();
	return rtable;
}
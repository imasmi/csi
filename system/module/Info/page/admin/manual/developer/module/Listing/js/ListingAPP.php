<h1>ListingAPP.js</h1>
    <span>ListingAPP.js is auto included only when user of type admin is logged in the system.</span>
    <span>Location: system/module/Listing/js/ListingAPP.js</span>

    <h3>ListingAPP.inside</h3>
        <span>Check if mouse position is over row for reordering.</span>
        <span>Returns true or false.</span>
        <ul>
            <li>
                <h4>ListingAPP.inside(DOM element)</h4>
                <p>Example: ListingAPP.inside(S("#row-14"))</p>
                <span>Checks if mouse cursor is over row 14.</span>
            </li>
        </ul>
        
    <h3>ListingAPP.drag</h3>
        <span>Attach mousemove event listener with the function ListingAPP.move ot an element.</span>
        <span>Starts the dragging efect for reposition.</span>
        <ul>
            <li>
                <h4>ListingAPP.drag(DOM element)</h4>
                <p>Example: ListingAPP.drag(S("#row-14"))</p>
                <span>Will atach ListingAPP.move to row 14 on mousemove.</span>
            </li>
        </ul>
    
    <h3>ListingAPP.move</h3>
        <span>Makes attached with ListingAPP.drag element to follow the cursor onmousedown over the element.</span>
    
    <h3>ListingAPP.stopDrag</h3>
        <span>Reorder row element onmouseup over another row element highlithed area.</span>
        <span>Release the mousemove listener from the current attached element with ListingAPP.drag.</span>
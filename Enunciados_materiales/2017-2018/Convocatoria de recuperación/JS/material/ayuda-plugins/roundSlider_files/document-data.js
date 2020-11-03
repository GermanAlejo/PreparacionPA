
window.defaults = {
    Properties: ["animation", "width", "circleShape", "disabled", "editableTooltip", "endAngle", "handleSize", "handleShape",
                    "keyboardAction", "max", "min", "mouseScrollAction", "radius", "readOnly",
                    "showTooltip", "sliderType", "startAngle", "step", "value"],
    Events: ["beforeCreate", "create", "start", "stop", "drag", "change"],
    Methods: ["setValue", "getValue", "disable", "enable", "destroy"]
};

window.details = {
    animation: {
        desc: [
            "<p>Enables or disables the handle movement animation.</p>" +

            "<p>As the control uses the CSS3 animation, so you can use any CSS3 transition effects " +
            "to customize the animation type and speed. To know how to use custom animation check " +
            "<a target='_blank' href='./demos.html#custom-animation'>here</a>" +
            ".</p>"
        ],
        type: "Boolean"
    },
    width: {
        desc: [
            "<p>Indicates the width (or thickness) of the slider.</p>"
        ],
        type: "Number"
    },
    circleShape: {
        desc: [
            "<p>Indicates the circle shape to be render. The available circle shapes are,</p>"
        ],
        list: ["full", "half-top", "half-bottom", "half-left", "half-right", "quarter-top-left", "quarter-top-right",
            "quarter-bottom-right", "quarter-bottom-left", "pie", "custom-half", "custom-quarter"],
        type: "String"
    },
    disabled: {
        desc: [
            "<p>Sets the disable state or enable state of the control. While the control in the disable " +
            "state we can't interact with this.</p>" +
            "<p>And in disable mode the control looks like in the blured state.</p>"

        ],
        type: "Boolean"
    },
    editableTooltip: {
        desc: [
            "<p>Enables the editable option of tooltip. When this property set as true, we can change the value by editing the tooltip.</p>"
        ],
        type: "Boolean"
    },
    endAngle: {
        desc: [
            "<p>Indicates the end point of the slider.</p>" +
            "<p>" +
                "<b>Multiple format supported:</b>" +
                "<ul>" +
                    "<li><code> 180 </code> : Sets the fixed value, where the endAngle is 180&deg;.</li>" +

                    '<li><code>"+180"</code> : This is dependent to ' +
                    "<a class='link' href='#startAngle'>startAngle</a>" +
                    ' property. If the startAngle is 90&deg; then the endAngle considered as 270&deg;.</li>' +

                    '<li><code>"-90"</code> : This is also dependent to ' +
                    "<a class='link' href='#startAngle'>startAngle</a>" +
                    ' property. If the startAngle is 180&deg; then the endAngle considered as 90&deg;.</li>' +
                "</ul>" +
            "</p>" +
            '<p>The endAngle property is applicable for "full" circle shape only. </p>'
        ],
        type: "String or Number"
    },
    handleSize: {
        desc: [
            "<p>The handleSize property mentions the size of the handle.</p>"+
            "<p>" +
                "<b>Multiple format supported:</b>" +
                "<ul>" +
                    "<li><code> 22 </code> : Sets the fixed size, where the handle's height and width considered as 22.</li>" +

                    '<li><code> "30,10" </code> : ' +
                    "Sets the fixed size, where the handle's height considered as 30 and width considered as 10.</li>" +

                    '<li><code>"+4"</code> : This is dependent to ' +
                    "<a class='link' href='#width'>width</a>" +
                    ' property. If the width is 20 then the handleSize considered as 24.</li>' +

                    '<li><code>"-4"</code> : This is also dependent to ' +
                    "<a class='link' href='#width'>width</a>" +
                    ' property. If the width is 20 then the handleSize considered as 16.</li>' +
                "</ul>" +
            "</p>"
        ],
        type: "String or Number"
    },
    handleShape: {
        desc: [
            "<p>The handleShape property mentions the shape of the handle. Currently the following types are available:</p>"
        ],
        list: ["round", "dot", "square"],
        desc1: [
            "<p>In addition you can make your own handle shape by customizing this. Please check " +
            "<a class='link' href='./demos.html#custom-handle-shape'>here</a>" +
            " for handle customization.</p>"
        ],
        type: "String"
    },
    keyboardAction: {
        desc: [
            "<p>Enables or disables the keyboard functionality.</p>" +
            "<p>The slider value can be changed through the keyboard by using the arrow keys (Up, Down, Left, Right) and Home, Down keys.</p>"
        ],
        type: "Boolean"
    },
    max: {
        desc: [
            "<p>The  max property indicates the maximum value of the slider.</p>"
        ],
        type: "Number"
    },
    min: {
        desc: [
            "<p>The min property indicates the minimum value of the slider.</p>"
        ],
        type: "Number"
    },
    mouseScrollAction: {
        desc: [
            "<p>Enables or disables the mouse scroll functionality.</p>" +
            "<p>The slider value can be changed through the mouse scrolling.</p>"
        ],
        type: "Boolean"
    },
    radius: {
        desc: [
            "<p>The radius property indicates the radius of the slider's circle.</p>" +
            "<p><b>Note : </b>The height and width of the control considered as (2 * radius).</p>"
        ],
        type: "Number"
    },
    readOnly: {
        desc: [
            "<p>This enables the control into the readOnly mode, so we can can't interact with the control when readOnly enabled.</p>"
        ],
        type: "Boolean"
    },
    showTooltip: {
        desc: [
            "<p>Enables or disables the tooltip inside the slider.</p>"
        ],
        type: "Boolean"
    },
    sliderType: {
        desc: [
            "<p>Indicates the slider type to be render. The available slider types are:</p>"
        ],
        list: ["default", "min-range", "range"],
        type: "String"
    },
    startAngle: {
        desc: [
            "<p>Indicates the starting point of the slider.</p>" +
            '<p>The startAngle property is applicable for "full", "custom-half", "custom-quarter" and "pie" circle shapes only. </p>'
        ],
        type: "Number"
    },
    step: {
        desc: [
            "<p>Decides the number of steps or value should take while we move the handle.</p>"
        ],
        type: "Number"
    },
    value: {
        desc: [
            "<p>Sets or gets the value of the slider.<p>" +
            "<p><div>For default and min-range slider the property allows a single value (<b>ex:</b> value - 10).</div>" +
            "<div>For range slider the property allows two values separated by comma (<b>ex:</b> value - \"30,60\").</div></p>"
        ],
        type: "String or Number"
    },
    beforeCreate: {
        desc: [
            "<p>This event triggered before the control will initialize.</p>" +
            "<p>At this point we can change the control's settings. And also this event can be cancellable, so we can prevent the control creation by 'return false'.<p>"
        ]
    },
    create: {
        desc: [
            "<p>This event triggered after the control creation or initialization.</p>"
        ]
    },
    start: {
        desc: [
            "<p>This event triggered when the user starts to drag the handle.</p>"
        ]
    },
    stop: {
        desc: [
            "<p>This event triggered when the user stops from sliding the handle / when releasing the handle.</p>"
        ]
    },
    drag: {
        desc: [
            "<p>This event triggered when the user moving the handle. On each mouse move the drag event will trigger.</p>"
        ]
    },
    change: {
        desc: [
            "<p>This event triggered when the slider's value gets change.</p>"
        ]
    },
    setValue: {
        desc: [
            "<p>This method is used to set the value to the slider control.</p>" +
            "<p><b>Note : </b> This method accepts the following possible parameters." +
                "<ul>" +
                    "<li>" +
                        "<b>setValue(value)</b> : This will set the corresponding value to the slider handle." +
                            "<pre><code>" +
                                "setValue(30) - for default and min-range slider " +
                                "\n\n" +
                                'setValue("30,60") - for range slider ' +
                            "</pre></code>" +
                    "</li>" +
                    "<li>" +
                        "<b>setValue(value, index)</b> : This is only applicable for range slider, which sets the value to the corresponding handle." +
                        "Here the possible value of index is 1 or 2 only." +
                        "<pre><code>" +
                                "setValue(35, 1) - it sets the first handle value as 35 " +
                            "</pre></code>" +
                    "</li>" +
                "</ul>" +
            "</p>"
        ]
    },
    getValue: {
        desc: [
            "<p>This method is used to get the value from the slider control.</p>" +
            "<p><b>Note : </b> This method accepts the following possible parameters." +
                "<ul>" +
                    "<li>" +
                        "<b>getValue()</b> : Without any parameter, it will return the current slider value." +
                            "<pre><code>" +
                                "getValue() - returns 30 for default and min-range slider " +
                                "\n\n" +
                                'getValue() - returns "30,60" for range slider ' +
                            "</pre></code>" +
                    "</li>" +
                    "<li>" +
                        "<b>getValue(index)</b> : This is only applicable for range slider, which returns the value of the corresponding handle. " +
                        "Here the possible value of index is 1 or 2 only." +
                        "<pre><code>" +
                                "getValue(1) - it returns the first handle value" +
                            "</pre></code>" +
                    "</li>" +
                "</ul>" +
            "</p>"
        ]
    },
    disable: {
        desc: [
            "<p>Disables the slider control.</p>" +
            "<p><b>Note : </b> This method does not accept any parameters." +
            
            "<pre><code>" +
                '$("#slider").roundSlider("disable");' +
            "</pre></code>"
        ]
    },
    enable: {
        desc: [
            "<p>Enables the slider control.</p>" +
            "<p><b>Note : </b> This method does not accept any parameters." +

            "<pre><code>" +
                '$("#slider").roundSlider("enable");' +
            "</pre></code>"
        ]
    },
    destroy: {
        desc: [
            "<p>Destroys the slider control and reverts the control element to the initial state.</p>" +
            "<p><b>Note : </b> This method does not accept any parameters." +

            "<pre><code>" +
                '$("#slider").roundSlider("destroy");' +
            "</pre></code>"
        ]
    }
};
<?php
/**
 * Nii class file.
 *
 * @author Newicon, Steven O'Brien <steven.obrien@newicon.net>
 * @link http://github.com/newicon/Nii
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 * 
 * 
 * Could be moved into the official oocss / nii css repository at a later date.
 * 
 */
?>
<div style="margin:auto;width:940px;">
    <h1>Oocss</h1>

    <section id="forms">
        <div class="page-header"><h1>Forms</h1></div>

        <div class="row">
            <div class="span4">
                <h2>Input Box Styles</h2>
                <p>
                    Forms in nii differ from the standard bootstrap forms.
                    A common html structure.  To make the magic work as described in these docs we need to ensure we run the associated js line:
                    <code>$.fn.nii.form();</code>
                </p>
            </div>
            <div class="span12">
                <form>
                    <h2>Default input box</h2>
                    <p>Input's have all styles reset. The visual styles for the box itself is drawn by a wrapper div which has the class of <code>input</code>. <br/> 
                        This is used to ensure that input boxes expand to the full width of their container, and do not break the container boundry.  Therefore widths and form input sizes must be applied to the container div and not to the input element itself.
                    </p>

                    <h4>Example of standard form input element</h4>
                    <div class="field">
                        <div class="input">
                            <input id="username" name="username" />
                        </div>
                    </div>

                    <?php $this->beginWidget('CTextHighlighter', array('language' => 'html')); ?>
                    <div class="field">
                        <div class="input">
                            <input id="username" name="username" />
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>

                    <p>Javascript sorts out interactive styles. The <code>.field</code> element is appended with the appropriate class to represent the field's state.</p>
                    <div class="line">
                        <div class="unit size1of4">
                            <div class="pam">
                                <p><code>.field.focus</code></p>
								<div class="field focused">
									<div class="input">
										<input id="username" name="username" />
									</div>
								</div>	
                                <p> you can also use <code>.focused</code> to manually control the focused style as the <code>.focus</code> class will be removed on input blur.</p>
                            </div>
                        </div>
                        <div class="unit size1of4">
                            <div class="pam">
                                <p><code>.field.error</code></p>
								<div class="field error">
									<div class="input">
										<input id="username" name="username" />
									</div>
								</div>	
                                <p>The error class is applied by yii when using yii client side form validation. You have to add this manually on page refresh.</p>
                            </div>
                        </div>
                        <div class="unit size1of4">
                            <div class="pam">
                                <p><code>.field.success</code></p>
								<div class="field success">
									<div class="input">
										<input id="username" name="username" />
									</div>
								</div>	
                            </div>
                        </div>
                        <div class="lastUnit">
                            <div class="pam">
                                <p><code>.field.validating</code></p>
                                <div class="field validating">
                                    <div class="input">
                                        <input id="username" name="username" />
                                    </div>
                                </div>	
                                <p>This class is automatically added by yii when validating, it is useful when using ajax validation. The styling is left up to you.</p>
                            </div>
                        </div>
                    </div>	


                    <h4>Using in field labels</h4>
                    <p>There is the new placeholder attribute in html5, this is cool but not well supported yet. Also the default behaviour in most browsers is still kinda fugly, we want to remove the label only when typing begins.</p>
                    <p>To add in-field-labels to an input we simply add the class <code>inFieldLabel</code> to a label element with it's for attribute linked to the appropriate input element</p>
                    <p><span class="label notice">Note</span> This plugin could be modified in the future to automatically add the label attribute and apply inFieldLabels when the placeholder tag is present on an input element</em></small>
                    <p><span class="label notice">Note</span> The input element needs to have a type defined otherwise the inFieldLabel does not work
                    <div class="field">
                        <label for="username_2" class="inFieldLabel" >Email</label>
                        <div class="input">
                            <input type="text" id="username_2" name="username_2">
                        </div>
                    </div>

                    <?php $this->beginWidget('CTextHighlighter', array('language' => 'html')); ?>
                    <div class="field">
                        <label for="username" class="inFieldLabel">Email</label>
                        <div class="input">
                            <input type="text" id="username" name="username">
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>


                    <p>The in-field-label is positioned absolutely therefore if you have additional elements in your field you require an additional div container like so:</p>
                    <div class="field stacked">
                        <label class="lbl">Enter your email:</label>
                        <div class="inputContainer">
                            <label for="username_3" class="inFieldLabel" >It is the thing with the @ in it</label>
                            <div class="input">
                                <input type="text" id="username_3" name="username_3">
                            </div>
                        </div>
                        <span class="hint">Put your email address in the box above</span>
                    </div>

                    <?php $this->beginWidget('CTextHighlighter', array('language' => 'html')); ?>
                    <div class="field stacked">
                        <label class="lbl">Enter your email:</label>
                        <div class="inputContainer">
                            <label for="username_3" class="inFieldLabel" >
                                It is the thing with the @ in it
                            </label>
                            <div class="input">
                                <input type="text" id="username_3" name="username_3">
                            </div>
                        </div>
                        <span class="hint">Put your email address in the box above</span>
                    </div>
                    <?php $this->endWidget(); ?>


                </form>
            </div>
        </div>

        <div class="row">
            <div class="span4">
                <h2>Form Layouts</h2>
                <p>Forms support two main layouts, stacked and float, these must be applied individually to each field block (a div with class of <code>.field</code> containing the input elements)</p>
            </div>
            <div class="span12">
                <h2>Stacked Form layouts</h2>

                <p>
                    To create a stacked form field layout use the <code>.stacked</code> class.
                </p>


				<form>

					<div class="field stacked">
						<label class="lbl" for="name">Name:</label>
						<div class="input">
							<input type="text" id="name" name="name">
						</div>
					</div>

					<div class="field stacked">
						<label class="lbl" for="email">Email:</label>
						<div class="inputContainer">
							<label for="email" class="inFieldLabel" >It is the thing with the @ in it</label>
							<div class="input">
								<input type="text" id="email" name="username_3">
							</div>
						</div>
					</div>

					<div class="field stacked">
						<label class="lbl" for="comment">Comment:</label>
						<div class="inputContainer">
							<label for="comment" class="inFieldLabel" >Enter a nice comment</label>
							<div class="input">
								<textarea id="comment" name="comment"></textarea>
							</div>
						</div>
					</div>

				</form>
                
				
				

				<?php $this->beginWidget('CTextHighlighter', array('language' => 'html')); ?>
	<form>

		<div class="field stacked">
			<label class="lbl" for="name">Name:</label>
			<div class="input"><input type="text" id="name" name="name"></div>
		</div>

		<div class="field stacked">
			<label class="lbl" for="email">Email:</label>
			<div class="inputContainer">
				<label for="email" class="inFieldLabel" >It is the thing with the @ in it</label>
				<div class="input"><input type="text" id="email" name="username_3"></div>
			</div>
		</div>

		<div class="field stacked">
			<label class="lbl" for="comment">Comment:</label>
			<div class="inputContainer">
				<label for="comment" class="inFieldLabel" >Enter a nice comment</label>
				<div class="input">
					<textarea id="comment" name="comment"></textarea>
				</div>
			</div>
		</div>

	</form>
				<?php $this->endWidget(); ?>
                

				<form >

					<div class="field float">
						<label class="lbl">Name:</label>
						<div class="input">
							<input type="text" id="username_3" name="username_3">
						</div>
					</div>

					<div class="field float">
						<label class="lbl">Email:</label>
						<div class="inputContainer">
							<label for="email2" class="inFieldLabel" >It is the thing with the @ in it</label>
							<div class="input">
								<input type="text" id="email2" name="wmail">
							</div>
						</div>
					</div>

					<div class="field float">
						<label class="lbl">Comment:</label>
						<div class="inputContainer">
							<label for="comment2" class="inFieldLabel" >Enter a nice comment</label>
							<div class="input">
								<textarea id="comment2" name="comment2"></textarea>
							</div>
						</div>
					</div>

				</form>




                <form>
                    <fieldset>
                        <legend>Example form legend</legend>	
                        <div class="field float">

                            <label class="lbl" for="xlInput">X-Large input</label>
                            <div class="input xlarge">
                                <input id="xlInput" name="xlInput" size="30" type="text" />
                            </div>
                        </div><!-- /field -->
                        <div class="field float">
                            <label class="lbl" for="normalSelect">Select</label>
                            <div class="input large">
                                <select name="normalSelect" id="normalSelect">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                        </div><!-- /field -->
                        <div class="field float">
                            <label class="lbl" for="mediumSelect">Select</label>
                            <div class="input medium">
                                <select name="mediumSelect" id="mediumSelect">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                        </div><!-- /field -->
                        <div class="field float">
                            <label class="lbl" for="multiSelect">Multiple select</label>
                            <div class="input medium">
                                <select multiple="multiple" name="multiSelect" id="multiSelect">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                        </div><!-- /field -->
                        <div class="field float">
                            <label class="lbl">Uneditable input</label>
                            <div class="input uneditable-input large">
<!--								<input readonly value="some read only value"/>-->
                                <span>Some value here</span>
                            </div>
                        </div><!-- /field -->
                        <div class="field float">
                            <label class="lbl" for="disabledInput">Disabled input</label>
                            <div class="input disabled xlarge">
                                <input id="disabledInput" name="disabledInput" size="30" type="text" placeholder="Disabled input here… carry on." disabled />
                            </div>
                        </div><!-- /field -->
                        <div class="field float">
                            <label class="lbl" for="disabledInput">Disabled textarea</label>
                            <div class="input disabled xxlarge">
                                <textarea name="textarea" id="textarea" rows="3" disabled></textarea>
                            </div>
                        </div><!-- /field -->
                        <div class="field error float">
                            <label class="lbl" for="xlInput2">X-Large input</label>
                            <div class="input xlarge">
                                <input id="xlInput2" name="xlInput2" size="30" type="text" />
                            </div>
                            <span class="help-inline">Small snippet of help text</span>
                        </div><!-- /field -->
                    </fieldset>
                    <fieldset >
                        <legend>Example form legend</legend>
                        <div class="field float">
                            <label class="lbl" for="prependedInput">Prepended text</label>
                            <div class="input">
                                <div class="input-prepend">
                                    <span class="add-on">@</span>
                                    <input class="medium" id="prependedInput" name="prependedInput" size="16" type="text" />
                                </div>
                            </div>
                        </div><!-- /field -->
                        <div class="field float">
                            <label for="prependedInput2">Prepended checkbox</label>
                            <div class="input">
                                <div class="input-prepend">
                                    <label class="add-on"><input type="checkbox" name="" id="" value="" /></label>
                                    <input class="mini" id="prependedInput2" name="prependedInput2" size="16" type="text" />
                                </div>
                            </div>
                        </div><!-- /field -->
                        <div class="field float">
                            <label for="appendedInput">Appended checkbox</label>
                            <div class="input">
                                <div class="input-append">
                                    <input class="mini" id="appendedInput" name="appendedInput" size="16" type="text" />
                                    <label class="add-on active"><input type="checkbox" name="" id="" value="" checked="checked" /></label>
                                </div>
                            </div>
                        </div><!-- /field -->
                        <div class="field float">
                            <label for="fileInput">File input</label>
                            <div class="input">
                                <input class="input-file" id="fileInput" name="fileInput" type="file" />
                            </div>
                        </div><!-- /field -->
                    </fieldset>
                    <fieldset class="float">
                        <legend>Example form legend</legend>
                        <div class="field">
                            <label class="lbl" id="optionsCheckboxes">List of options</label>
                                <ul class="inputs-list">
                                    <li>
                                        <label>
                                            <input type="checkbox" name="optionsCheckboxes" value="option1" />
                                            <span>Option one is this and that&mdash;be sure to include why it’s great</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="optionsCheckboxes" value="option2" />
                                            <span>Option two can also be checked and included in form results</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="optionsCheckboxes" value="option2" />
                                            <span>Option three can&mdash;yes, you guessed it&mdash;also be checked and included in form results</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="optionsCheckboxes" value="option2" disabled />
                                            <span>Option four cannot be checked as it is disabled.</span>
                                        </label>
                                    </li>
                                </ul>
                                <span class="help-block">
                                    <strong>Note:</strong> Labels surround all the options for much larger click areas and a more usable form.
                                </span>
                        </div><!-- /field -->
                        <div class="field">
                            <label class="lbl" for="date">Date range</label>
							<div class="line">
								<div class="field unit">
									<div class="input joinedRight small">
										<input id="date" type="text" value="May 1, 2011" />
									</div>
								</div>
								<div class="field unit">
									<div class="input joinedLeft mini">
										<input type="text" value="12:00am" />
									</div>
								</div>
								<div class="unit pts">&nbsp;to&nbsp;</div>
								<div class="field unit">
									<div class="input joinedRight small">
										<input type="text" value="May 8, 2011" />
									</div>
								</div>
								<div class="field unit">
									<div class="input joinedLeft mini">
										<input type="text" value="11:59pm" />
									</div>
								</div>
							</div>
							<span class="hint">All times are shown as Pacific Standard Time (GMT -08:00).</span>
                        </div><!-- /field -->
						 <div class="field">
                            <label class="lbl" for="date">Date range</label>
							<div class="line">
								<div class="field unit mrs">
									<div class="input small">
										<input id="date" type="text" value="May 1, 2011" />
									</div>
								</div>
								<div class="field unit mrs">
									<div class="input mini">
										<input type="text" value="12:00am" />
									</div>
								</div>
								<div class="unit mrs pts">&nbsp;to&nbsp;</div>
								<div class="field unit mrs">
									<div class="input small">
										<input type="text" value="May 8, 2011" />
									</div>
								</div>
								<div class="field unit">
									<div class="input mini">
										<input type="text" value="11:59pm" />
									</div>
								</div>
							</div>
							<span class="hint">All times are shown as Pacific Standard Time (GMT -08:00).</span>
                        </div><!-- /field -->
						<div class="field stacked">
                            <label class="lbl" for="first_name">Name</label>
							<div class="line">
								<div class="field unit mrs">
									<div class="input small">
										<input id="first_name" type="text" value="" />
									</div>
									<label class="hint">First</label>
								</div>
								<div class="field unit">
									<div class="input small">
										<input id="last_name" type="text" value="" />
									</div>
									<label class="hint">Last</label>
								</div>
							</div>
                        </div><!-- /field -->
                        <div class="field">
                            <label class="lbl" for="textarea2">Textarea</label>
                            <div class="input">
                                <textarea class="xxlarge" id="textarea2" name="textarea2" rows="3"></textarea>
                            </div>
							<span class="hint">
								Block of help text to describe the field above if need be.
							</span>
                        </div><!-- /field -->
                        <div class="field float">
                            <label class="lbl" id="optionsRadio">List of options</label>
							<ul class="inputs-list">
								<li>
									<label>
										<input type="radio" checked name="optionsRadios" value="option1" />
										<span>Option one is this and that&mdash;be sure to include why it’s great</span>
									</label>
								</li>
								<li>
									<label>
										<input type="radio" name="optionsRadios" value="option2" />
										<span>Option two can is something else and selecting it will deselect options 1</span>
									</label>
								</li>
							</ul>
                        </div><!-- /field -->
                        <div class="actions">
                            <input type="submit" class="btn primary" value="Save changes">&nbsp;<button type="reset" class="btn">Cancel</button>
                        </div>
                    </fieldset>
                </form>

            </div>


        </div>

    </section>
</div>
<script>
    $.fn.nii.form();
</script>




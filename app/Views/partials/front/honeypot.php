<?php
/**
 * Bot bait. Hidden from people (and from screen readers, via aria-hidden and
 * tabindex), so anything that arrives filled in was not typed by a visitor.
 * The controller silently accepts and discards those submissions rather than
 * saying what it noticed.
 */
?>
<div class="c-hp" aria-hidden="true">
  <label for="website">Website</label>
  <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
</div>

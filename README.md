## Better Module Manager

Better Module Manager is a GPL fork of the pro version of Regular Labs' Adanced Module Manager (https://www.regularlabs.com/extensions/advancedmodulemanager).


### Differences

- Does not include the "Regular Labs Library". The "Regular Labs Library" must be separately installed. If the "Regular Labs Library" is not installed, Better Module Manager cannot run.

- Only one language pack included: en-GB.

- Removed "geo" assignments


### Long-term goal

Convert the monolithic "publishing assignments" code to a flexible plugin architecture. 


### Framework installation

The Regular Labs Library is an integral part of the Better Module Manager extension. The Regular Labs Library however, is not automatically installed with the Better Module Manager extension, and must be separately installed. If you are using any Regular Labs extensions, the Regular Labs Library may already be installed on your site. If not, you can install the Regular Labs Library by installing and immediately un-installing a Regular Labs extension - like for example the free version of Advanced Module Manager.

### Migration

Migration from Advanced Module Manager is not complicated but must be done before installing Better Module Manager (or after uninstalling Better Module Manager).

Quick guide to migration:

1 Install (or update to) the latest Advanced Module Manager extension (free version)
2 Uninstall Advanced Module Manager (this will not uninstall the Regular Labs Library)
3 Rename the Advanced Module Manager table (see below)
4 Install Better Module Manager

For example, in MySQL you can migrate the data as shown here:

    DROP TABLE IF EXISTS joomlaprefix_bettermodules;
    RENAME TABLE joomlaprefix_advancedmodules TO joomlaprefix_bettermodules;

If you have never used Advanced Module Manager, then you can skip step 3.

Before making any changes to your site, it's best practice to always create a backup.

https://docs.joomla.org/How_to_determine_your_database_prefix



### LICENSE

Better Module Manager - A better module manager for Joomla

Copyright (c) 2016 NoNescio  
Copyright (c) 2010 - 2016 Regular Labs (www.regularlabs.com)

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

GNU General Public License http://www.gnu.org/licenses/gpl-2.0.html



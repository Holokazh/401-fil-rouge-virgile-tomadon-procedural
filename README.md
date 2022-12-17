# Qu'est ce qu'une API ?
API est l'acronyme d'Application Programming Interface. 

L'API permet à des applications de communiquer entre elles et de s'échanger mutuellement des services ou des données.





URL de l'API type : https://filrouge.uha4point0.fr/V2/pokemon/types

# API Type :
ID → Numéro unique permettant d'identifier l'objet
Nom → Chaîne de caractère représentant le nom du type
Caractéristique → Chaîne de caractère représentant la caractéristique du type
Attaques → Tableau représentant les différentes attaques du type




URL de l'API pokémon : https://filrouge.uha4point0.fr/V2/pokemon/pokemons

# API Pokémon :
ID → Numéro unique permettant d'identifier l'objet
Nom → Chaîne de caractère représentant le nom du pokémon
Type → Clé étrangère faisant référence au type du pokémon
Image → Chaîne de caractère représentant une URL de l'image du pokémon


# Résumé :

# API pokémon

Le site se nommera PokéChill

PokéChill permettra à l'utilisateur de voir le détail, d'ajouter, de modifier et de supprimer des pokémons.

Chaque pokémon sera associé à un type. (eau, dragon, plante...)

PokéChill permettra à l'utilisateur de voir le détail, d'ajouter, de modifier et de supprimer des types.

Un type possèdera des attaques.

PokéChill permettra à l'utilisateur d'ajouter, de modifier et de supprimer des attaques.

L'utilisateur pourra relier des attaque à un type, une attaque peut être relié à plusieurs types.



# Documentation :

- Accéder au projet

- Accéder au terminal de commande

- Exécuter la commande suivante afin de cloner le projet sur votre machine

- git clone ssh://git@git.uha4point0.fr:22222/UHA40/fils-rouges-2022/4.0.1/fil-rouge-virgile-tomadon.git

- La base de données se nommera "pokemon" et sera créée directement au lancement du projet dans votre navigateur.                   (Attention à ne pas avoir une base de données possédant le même nom, sinon elle sera remplacée.)

- Accéder au fichier database.php dans le dossier bdd se trouvant à la racine du projet, et veillez à changer les variables de connexion
ligne 6, 7, 8 et 9.

- Accéder au projet via index.php

- Une barre de navigation sous le titre du site permet de naviguer entre les pokémons, les types ainsi que les attaques

- Un bouton "Réinitialiser la BDD" permettra de réinitialiser entièrement la base de données avec les données de 

- Cliquez sur pokémon pour accéder à la liste des pokémons

- Depuis cette vue vous pouvez créer un pokémon, et voir le détail d'un pokémon en cliquant sur celui-ci.

- Depuis la vue du détail d'un pokémon, vous pouvez le modifier ou bien le supprimer.

- Cliquez sur type pour accéder à la liste des types

- Depuis cette vue vous pouvez créer un type, et voir le détail d'un type en cliquant sur celui-ci.

- Depuis la vue du détail d'un type, vous pouvez le modifier, le supprimer et ajouter des attaques existantes à ce type.

- Cliquez sur attaque pour accéder à la liste des attaques 

- Depuis cette vue vous pouvez créer, modifier ou supprimer une attaque.

<!-- # fil rouge virgile tomadon



## Getting started

To make it easy for you to get started with GitLab, here's a list of recommended next steps.

Already a pro? Just edit this README.md and make it your own. Want to make it easy? [Use the template at the bottom](#editing-this-readme)!

## Add your files

- [ ] [Create](https://docs.gitlab.com/ee/user/project/repository/web_editor.html#create-a-file) or [upload](https://docs.gitlab.com/ee/user/project/repository/web_editor.html#upload-a-file) files
- [ ] [Add files using the command line](https://docs.gitlab.com/ee/gitlab-basics/add-file.html#add-a-file-using-the-command-line) or push an existing Git repository with the following command:

```
cd existing_repo
git remote add origin http://git.uha4point0.fr/UHA40/fils-rouges-2022/4.0.1/fil-rouge-virgile-tomadon.git
git branch -M main
git push -uf origin main
```

## Integrate with your tools

- [ ] [Set up project integrations](http://git.uha4point0.fr/UHA40/fils-rouges-2022/4.0.1/fil-rouge-virgile-tomadon/-/settings/integrations)

## Collaborate with your team

- [ ] [Invite team members and collaborators](https://docs.gitlab.com/ee/user/project/members/)
- [ ] [Create a new merge request](https://docs.gitlab.com/ee/user/project/merge_requests/creating_merge_requests.html)
- [ ] [Automatically close issues from merge requests](https://docs.gitlab.com/ee/user/project/issues/managing_issues.html#closing-issues-automatically)
- [ ] [Enable merge request approvals](https://docs.gitlab.com/ee/user/project/merge_requests/approvals/)
- [ ] [Automatically merge when pipeline succeeds](https://docs.gitlab.com/ee/user/project/merge_requests/merge_when_pipeline_succeeds.html)

## Test and Deploy

Use the built-in continuous integration in GitLab.

- [ ] [Get started with GitLab CI/CD](https://docs.gitlab.com/ee/ci/quick_start/index.html)
- [ ] [Analyze your code for known vulnerabilities with Static Application Security Testing(SAST)](https://docs.gitlab.com/ee/user/application_security/sast/)
- [ ] [Deploy to Kubernetes, Amazon EC2, or Amazon ECS using Auto Deploy](https://docs.gitlab.com/ee/topics/autodevops/requirements.html)
- [ ] [Use pull-based deployments for improved Kubernetes management](https://docs.gitlab.com/ee/user/clusters/agent/)
- [ ] [Set up protected environments](https://docs.gitlab.com/ee/ci/environments/protected_environments.html)

***

# Editing this README

When you're ready to make this README your own, just edit this file and use the handy template below (or feel free to structure it however you want - this is just a starting point!).  Thank you to [makeareadme.com](https://www.makeareadme.com/) for this template.

## Suggestions for a good README
Every project is different, so consider which of these sections apply to yours. The sections used in the template are suggestions for most open source projects. Also keep in mind that while a README can be too long and detailed, too long is better than too short. If you think your README is too long, consider utilizing another form of documentation rather than cutting out information.

## Name
Choose a self-explaining name for your project.

## Description
Let people know what your project can do specifically. Provide context and add a link to any reference visitors might be unfamiliar with. A list of Features or a Background subsection can also be added here. If there are alternatives to your project, this is a good place to list differentiating factors.

## Badges
On some READMEs, you may see small images that convey metadata, such as whether or not all the tests are passing for the project. You can use Shields to add some to your README. Many services also have instructions for adding a badge.

## Visuals
Depending on what you are making, it can be a good idea to include screenshots or even a video (you'll frequently see GIFs rather than actual videos). Tools like ttygif can help, but check out Asciinema for a more sophisticated method.

## Installation
Within a particular ecosystem, there may be a common way of installing things, such as using Yarn, NuGet, or Homebrew. However, consider the possibility that whoever is reading your README is a novice and would like more guidance. Listing specific steps helps remove ambiguity and gets people to using your project as quickly as possible. If it only runs in a specific context like a particular programming language version or operating system or has dependencies that have to be installed manually, also add a Requirements subsection.

## Usage
Use examples liberally, and show the expected output if you can. It's helpful to have inline the smallest example of usage that you can demonstrate, while providing links to more sophisticated examples if they are too long to reasonably include in the README.

## Support
Tell people where they can go to for help. It can be any combination of an issue tracker, a chat room, an email address, etc.

## Roadmap
If you have ideas for releases in the future, it is a good idea to list them in the README.

## Contributing
State if you are open to contributions and what your requirements are for accepting them.

For people who want to make changes to your project, it's helpful to have some documentation on how to get started. Perhaps there is a script that they should run or some environment variables that they need to set. Make these steps explicit. These instructions could also be useful to your future self.

You can also document commands to lint the code or run tests. These steps help to ensure high code quality and reduce the likelihood that the changes inadvertently break something. Having instructions for running tests is especially helpful if it requires external setup, such as starting a Selenium server for testing in a browser.

## Authors and acknowledgment
Show your appreciation to those who have contributed to the project.

## License
For open source projects, say how it is licensed.

## Project status
If you have run out of energy or time for your project, put a note at the top of the README saying that development has slowed down or stopped completely. Someone may choose to fork your project or volunteer to step in as a maintainer or owner, allowing your project to keep going. You can also make an explicit request for maintainers. -->

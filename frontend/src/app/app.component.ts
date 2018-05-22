import {Component, OnInit} from '@angular/core';
import {Question} from "./Question";
import {QuestionService} from "./question.service";
import {Answer} from "./Answer";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent{
  title = 'app';
  question: Question;
  questionsIds = [];
  correctAnswers: number = 0;
  isChecked: boolean = false;

  constructor(private questionService: QuestionService) {

  }

  showQuestion() {
    if (this.questionsIds.length < 10) {
      this.questionService.getQuestion().subscribe((data: Question) => {
        console.log(this.questionsIds.indexOf(data.id));
        if (this.questionsIds.indexOf(data.id) !== -1) {
          this.showQuestion();
        }
        this.question = data;
        this.questionsIds.push(this.question.id);
        this.isChecked = false;
      });
    } else {
      console.log("DUPA");
    }
  }

  checkAnswer(elem: Answer) {
    if (elem.isCorrect) {
      this.correctAnswers++;
      this.isChecked = true;
    }

    setTimeout(() => {
      this.showQuestion();
    }, 1000)
  }
}
